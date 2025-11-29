<?php

// Routes protégées (owner seulement)
use App\Http\Controllers\CompanyInvitationController;

Route::middleware('auth')->group(function () {
    Route::get('/company/invitations', [CompanyInvitationController::class, 'index']);
    Route::get('/company/my-invitations', [CompanyInvitationController::class, 'myInvitations']);
    Route::post('/company/invitations', [CompanyInvitationController::class, 'store']);
    Route::post('/company/invitations/{id}/resend', [CompanyInvitationController::class, 'resend']);
    Route::post('/invitations/{token}/accept', [CompanyInvitationController::class, 'acceptInvitation']);
    Route::post('/invitations/{token}/decline', [CompanyInvitationController::class, 'declineInvitation']);
    Route::delete('/company/invitations/{id}', [CompanyInvitationController::class, 'destroy']);
    Route::delete('/company/recruiters/{id}', [CompanyInvitationController::class, 'removeRecruiter']);
});

// Route publique pour accepter l'invitation
Route::get('/invitations/{token}', [CompanyInvitationController::class, 'accept']);
