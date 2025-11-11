<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\ApplicationUpdateRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Job;

class ApplicationController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Application::class);

        $applications = Application::with(['job', 'job.compagny', 'candidat'])->get();

        return ApplicationResource::collection($applications);
    }

    public function store(ApplicationRequest $request)
    {
        $this->authorize('create', Application::class);

        $data = $request->validated();
        $data['candidat_id'] = auth()->id();
        if($request->hasFile('cv')){
            $data['cv'] = $request->file('cv')->store('cvs', 'public');
        }

        $application = Application::create($data);
        $application->load(['job', 'job.compagny', 'candidat']);

        return new ApplicationResource($application);
    }

    public function show(Application $application)
    {
        $this->authorize('view', $application);

        $application->load(['job', 'job.compagny', 'candidat']); // Charger les relations

        return new ApplicationResource($application);
    }

    public function showByJob(Job $job)
    {
        $applications = Application::where('job_id', $job->id)
            ->with(['job', 'job.compagny', 'candidat'])->get();
        return ApplicationResource::collection($applications);
    }

    public function update(ApplicationUpdateRequest $request, Application $application)
    {
        $this->authorize('update', $application);

        $application->update($request->validated());

        $application->load(['job', 'job.compagny', 'candidat']); // Recharger les relations

        return new ApplicationResource($application);
    }

    public function destroy(Application $application)
    {
        $this->authorize('delete', $application);
        // Optionally, delete the CV file here if needed
        if ($application->cv && \Storage::disk('public')->exists($application->cv)) {
            \Storage::disk('public')->delete($application->cv);
        }

        $application->delete();

        return response()->json();
    }
}
