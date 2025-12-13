<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;

class ProfileController extends Controller
{

    /**
     * My Profile.
     */
    public function index()
    {
        $this->authorize('viewAny', Profile::class);
        $profile = Profile::with(['user', 'skills'])
            ->where('user_id', auth()->id())
            ->first();
        return new ProfileResource($profile);
    }
    /**
     *  Create Profile.
     */
    public function store(ProfileRequest $request)
    {
        $this->authorize('create', Profile::class);
        $data = $request->validated();

        // Si user_id n'est pas fourni, utiliser l'utilisateur authentifié
        $user = auth()->user();
        $data['user_id'] = $user->id;
        // generate a unique slug based on first_name and name
        $data['slug'] = \Str::slug($user->firstname . ' ' . $user->name . '-' . uniqid());

        $profile = Profile::create($data);
        // Attacher les skills si fournis
        if (isset($data['skills']) && is_array($data['skills'])) {
            $this->syncSkills($profile, $data['skills']);
        }

        $profile->load(['user', 'skills']);

        return new ProfileResource($profile);
    }

    /**
     * Show Profile by slug.
     */
    public function showBySlug($profile)
    {
        $profile = Profile::with(['user', 'skills'])::where('slug', $profile)->firstOrFail();
        $this->authorize('view', $profile);
        return new ProfileResource($profile);
    }

    /**
     * Update Profile by slug.
     */
    public function update(ProfileRequest $request,  $slug)
    {
        $profile = Profile::where('slug', $slug)->firstOrFail();
        $this->authorize('update', $profile);
        $data = $request->validated();

        // Mettre à jour les skills si fourni
        if (isset($data['skills']) && is_array($data['skills'])) {
            $this->syncSkills($profile, $data['skills']);
        }
        $profile->update($data);
        $profile->load(['user', 'skills']);
        return new ProfileResource($profile);
    }

    /**
     * Delete Profile.
     */
    public function destroy(Profile $profile)
    {
        $this->authorize('delete', $profile);

        $profile->delete();

        return response()->json();
    }

    /**
     * Sync skills with levels.
     */
    private function syncSkills(Profile $profile, array $skills)
    {
        $syncData = [];
        foreach ($skills as $skill) {
            if (isset($skill['skill_id']) && isset($skill['level'])) {
                $syncData[$skill['skill_id']] = ['level' => $skill['level']];
            }
        }
        $profile->skills()->sync($syncData);
    }
}
