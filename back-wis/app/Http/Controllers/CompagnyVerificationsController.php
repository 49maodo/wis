<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyVerificationsRequest;
use App\Http\Resources\CompagnyVerificationsResource;
use App\Models\CompagnyVerifications;

class CompagnyVerificationsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', CompagnyVerifications::class);
        $verifications = CompagnyVerifications::where('submitted_by', auth()->id())->get();

        return CompagnyVerificationsResource::collection($verifications);
    }

    public function store(CompanyVerificationsRequest $request)
    {
        $this->authorize('create', CompagnyVerifications::class);
        $data = $request->validated();
        $data['submitted_by'] = auth()->id();

        return new CompagnyVerificationsResource(CompagnyVerifications::create($data)->load('compagny'));
    }

    public function show(CompagnyVerifications $companyVerifications)
    {
        $this->authorize('view', $companyVerifications);

        return new CompagnyVerificationsResource($companyVerifications);
    }
}
