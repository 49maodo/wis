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
        $data = $request->validated();

        // Si user_id n'est pas fourni, utiliser l'utilisateur authentifié
        $data['user_id'] = auth()->id();


        $profile = Profile::create($data);

        return new ProfileResource($profile->load('user'));
    }

    public function show(Profile $profile)
    {
        $this->authorize('view', $profile);

        return new ProfileResource($profile);
    }

    public function update(ProfileRequest $request, Profile $profile)
    {
        $this->authorize('update', $profile);
        $data = $request->validated();

        $profile->update($data);
        return new ProfileResource($profile->fresh()->load('user'));
    }

    public function destroy(Profile $profile)
    {
        $this->authorize('delete', $profile);

        $profile->delete();

        return response()->json();
    }
}
