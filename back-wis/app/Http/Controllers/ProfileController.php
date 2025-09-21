<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Profile::class);

        return ProfileResource::collection(Profile::all());
    }

    public function store(ProfileRequest $request)
    {
        $this->authorize('create', Profile::class);

        return new ProfileResource(Profile::create($request->validated()));
    }

    public function show(Profile $profile)
    {
        $this->authorize('view', $profile);

        return new ProfileResource($profile);
    }

    public function update(ProfileRequest $request, Profile $profile)
    {
        $this->authorize('update', $profile);

        $profile->update($request->validated());

        return new ProfileResource($profile);
    }

    public function destroy(Profile $profile)
    {
        $this->authorize('delete', $profile);

        $profile->delete();

        return response()->json();
    }
}
