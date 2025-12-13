<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Http\Resources\JobResource;
use App\Models\Job;

class JobController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Job::class);
        $jobs = Job::with(['recruiter.compagny', 'recruiter','skills'])->get();

        return JobResource::collection($jobs);
    }

    public function store(JobRequest $request)
    {
        $this->authorize('create', Job::class);
        $data = $request->validated();

        // Si user_id n'est pas fourni, utiliser l'utilisateur authentifié
        $data['creatorId'] = auth()->id();

        $job = Job::create($data);
        if (isset($data['skills']) && is_array($data['skills'])) {
            $this->syncSkills($job, $data['skills']);
        }
        $job->load(['recruiter.compagny', 'recruiter', 'skills']);

        return new JobResource($job);
    }

    public function show(Job $job)
    {
        $this->authorize('view', $job);
        $job->load(['recruiter.compagny', 'recruiter', 'skills',])->loadCount('applications')->get();

        // with application count
//        if (auth()->user()){
//            $job::loadCount(['applications']);
//        }

        return new JobResource($job);
    }

    public function update(JobRequest $request, Job $job)
    {
        $this->authorize('update', $job);
        $data = $request->validated();
        if (isset($data['skills']) && is_array($data['skills'])) {
            $this->syncSkills($job, $data['skills']);
        }
        $job->update($data);
        $job->load(['recruiter.compagny', 'recruiter', 'skills']);
        return new JobResource($job);
    }

    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);

        $job->delete();

        return response()->json();
    }

    /**
     * Sync skills with levels.
     */
    private function syncSkills(Job $job, array $skills)
    {
        $syncData = [];
        foreach ($skills as $skill) {
            if (isset($skill['skill_id']) && isset($skill['level'])) {
                $syncData[$skill['skill_id']] = ['level' => $skill['level']];
            }
        }
        $job->skills()->sync($syncData);
    }
}
