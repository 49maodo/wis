<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompagnyRequest;
use App\Http\Resources\CompagnyResource;
use App\Models\Compagny;

class CompagnyController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Compagny::class);
        $compagnies = Compagny::all();
        $compagnies->load('owner', 'verifications', 'verifications.submittedBy', 'recruiters');
        return CompagnyResource::collection($compagnies);
    }

    public function getMyCompagnie()
    {
        $user = auth()->user();
        if (!$user || !$user->compagny_id) {
            return response()->json(null, 204);
        }

        $compagny = Compagny::find($user->compagny_id);

        if (!$compagny) {
            return response()->json(null, 204);
        }

        $this->authorize('view', $compagny);

        $compagny->load('owner', 'verifications', 'verifications.submittedBy', 'recruiters');

        return new CompagnyResource($compagny);
    }

    public function store(CompagnyRequest $request)
    {
        $this->authorize('create', Compagny::class);
        $data = $request->validated();

        if($request->hasFile('logo')){
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $user = auth()->user();
        $data['owner_id'] = $user->id;
        // update user compagny_id
        $compagny = Compagny::create($data);
        $user->compagny_id = $compagny->id;
        $user->save();

        return new CompagnyResource($compagny->load('owner'));
    }

    public function show(Compagny $compagny)
    {
        $this->authorize('view', $compagny);

        $compagny->load('owner', 'verifications', 'verifications.submittedBy', 'recruiters');

        return new CompagnyResource($compagny);
    }

    public function update(CompagnyRequest $request, Compagny $compagny)
    {
        $this->authorize('update', $compagny);

        $data = $request->validated();
        if($request->hasFile('logo')){
            // Optionally, delete the old logo file here if needed
            $oldLogo = $compagny->logo;
            if ($oldLogo && \Storage::disk('public')->exists($oldLogo)) {
                \Storage::disk('public')->delete($oldLogo);
            }

            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $compagny->update($data);

        $compagny->load('owner', 'verifications', 'verifications.submittedBy', 'recruiters');

        return new CompagnyResource($compagny);
    }

    public function destroy(Compagny $compagny)
    {
        $this->authorize('delete', $compagny);
        // Optionally, delete the logo file here if needed
        $oldLogo = $compagny->logo;
        if ($oldLogo && \Storage::disk('public')->exists($oldLogo)) {
            \Storage::disk('public')->delete($oldLogo);
        }

        $compagny->delete();


        return response()->json();
    }
}
