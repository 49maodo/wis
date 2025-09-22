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

        return JobResource::collection(Job::with(['compagny', 'recruiter'])->get());
    }

    public function store(JobRequest $request)
    {
        $this->authorize('create', Job::class);
        $data = $request->validated();

        // Si user_id n'est pas fourni, utiliser l'utilisateur authentifié
        $data['creatorId'] = auth()->id();
        $data['compagny_id'] = auth()->user()->compagny->id;

        return new JobResource(Job::create($data)::with(['compagny', 'recruiter']));
    }

    public function show(Job $job)
    {
        $this->authorize('view', $job);

        return new JobResource($job);
    }

    public function update(JobRequest $request, Job $job)
    {
        $this->authorize('update', $job);

        $job->update($request->validated());

        return new JobResource($job);
    }

    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);

        $job->delete();

        return response()->json();
    }
}
