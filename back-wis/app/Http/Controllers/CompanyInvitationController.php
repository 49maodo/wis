<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\CompanyInvitation;
use App\Models\User;
use App\Notifications\RecruiterInvitationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CompanyInvitationController extends Controller
{
    /**
     * Liste des invitations de l'entreprise
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->compagny || $user->compagny->owner_id !== $user->id) {
            return response()->json([
                'message' => 'Vous devez être propriétaire d\'une entreprise.'
            ], 403);
        }

        $invitations = CompanyInvitation::where('compagny_id', $user->compagny_id)
            ->where('accepted_at', null)
            ->with(['inviter', 'user'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($invitation) {
                return [
                    'id' => $invitation->id,
                    'email' => $invitation->email,
                    'token' => $invitation->token,
                    'invited_by' => [
                        'name' => $invitation->inviter->firstname . ' ' . $invitation->inviter->name,
                        'email' => $invitation->inviter->email,
                    ],
                    'user' => $invitation->user ? [
                        'id' => $invitation->user->id,
                        'firstname' => $invitation->user->firstname,
                        'name' => $invitation->user->name,
                        'email' => $invitation->user->email,
                        'phoneNumber' => $invitation->user->phoneNumber,
                    ] : null,
                    'status' => $invitation->accepted_at ? 'accepted' : ($invitation->isExpired() ? 'expired' : 'pending'),
                    'expires_at' => $invitation->expires_at->toISOString(),
                    'accepted_at' => $invitation->accepted_at?->toISOString(),
                    'created_at' => $invitation->created_at->toISOString(),
                    'invitation_url' => $invitation->getInvitationUrl(),
                ];
            });

        return response()->json(['data' => $invitations]);
    }

    /**
     * Liste de mes invitations
     */
    public function myInvitations(Request $request)
    {
        $user = $request->user();
        $invitations = CompanyInvitation::where('email', $user->email)
            ->where('accepted_at', '=', null)
            ->with(['compagny', 'inviter'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($invitation) {
                return [
                    'id' => $invitation->id,
                    'email' => $invitation->email,
                    'token' => $invitation->token,
                    'company' => [
                        'id' => $invitation->compagny->id,
                        'name' => $invitation->compagny->name,
                    ],
                    'invited_by' => [
                        'name' => $invitation->inviter->firstname . ' ' . $invitation->inviter->name,
                        'email' => $invitation->inviter->email,
                    ],
                    'status' => $invitation->accepted_at ? 'accepted' : ($invitation->isExpired() ? 'expired' : 'pending'),
                    'expires_at' => $invitation->expires_at->toISOString(),
                    'accepted_at' => $invitation->accepted_at?->toISOString(),
                    'created_at' => $invitation->created_at->toISOString(),
                    'invitation_url' => $invitation->getInvitationUrl(),
                ];
            });
        return response()->json(['data' => $invitations]);
    }
    /**
     * Créer et envoyer une invitation
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // Vérifier que l'utilisateur est owner
        if (!$user->compagny || $user->compagny->owner_id !== $user->id) {
            return response()->json([
                'message' => 'Seul le propriétaire de l\'entreprise peut inviter des recruteurs.'
            ], 403);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation échouée',
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->email;

        // Vérifier si l'utilisateur existe déjà
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            if ($existingUser->compagny_id === $user->compagny->id) {
                return response()->json([
                    'message' => 'Cet utilisateur fait déjà partie de votre entreprise.'
                ], 422);
            }
//            else {
//                return response()->json([
//                    'message' => 'Cet utilisateur est déjà enregistré dans une autre entreprise.'
//                ], 422);
//            }
        }

        // Vérifier si une invitation valide existe déjà
        $existingInvitation = CompanyInvitation::where('email', $email)
            ->where('compagny_id', $user->compagny->id)
            ->where('accepted_at', null)
            ->where('expires_at', '>', now())
            ->first();

        if ($existingInvitation) {
            return response()->json([
                'message' => 'Une invitation est déjà en attente pour cet email.',
                'data' => [
                    'invitation_url' => $existingInvitation->getInvitationUrl(),
                    'expires_at' => $existingInvitation->expires_at->toISOString(),
                ]
            ], 422);
        }

        // Créer l'invitation
        $invitation = CompanyInvitation::create([
            'compagny_id' => $user->compagny->id,
            'invited_by' => $user->id,
            'email' => $email,
            'token' => CompanyInvitation::generateToken(),
            'expires_at' => Carbon::now()->addDays(1), // Expire dans 1 jour
        ]);

        // Envoyer l'email
        Notification::route('mail', $email)
            ->notify(new RecruiterInvitationNotification($invitation));

        return response()->json([
            'message' => 'Invitation envoyée avec succès.',
            'data' => [
                'id' => $invitation->id,
                'email' => $invitation->email,
                'user' => $existingUser ? [
                    'id' => $existingUser->id,
                    'firstname' => $existingUser->firstname,
                    'name' => $existingUser->name,
                    'email' => $existingUser->email,
                    'phoneNumber' => $existingUser->phoneNumber,
                ] : null,
                'invitation_url' => $invitation->getInvitationUrl(),
                'expires_at' => $invitation->expires_at->toISOString(),
            ]
        ], 201);
    }

    /**
     * Renvoyer une invitation
     */
    public function resend(Request $request, $id)
    {
        $user = $request->user();

        if (!$user->compagny || $user->compagny->owner_id !== $user->id) {
            return response()->json([
                'message' => 'Non autorisé.'
            ], 403);
        }

        $invitation = CompanyInvitation::where('id', $id)
            ->where('compagny_id', $user->compagny->id)
            ->first();

        if (!$invitation) {
            return response()->json(['message' => 'Invitation introuvable.'], 404);
        }

        if ($invitation->accepted_at) {
            return response()->json([
                'message' => 'Cette invitation a déjà été acceptée.'
            ], 422);
        }

        // Prolonger la date d'expiration
        $invitation->update([
            'expires_at' => Carbon::now()->addDays(1),
        ]);

        // Renvoyer l'email
        Notification::route('mail', $invitation->email)
            ->notify(new RecruiterInvitationNotification($invitation));

        return response()->json([
            'message' => 'Invitation renvoyée avec succès.',
            'data' => [
                'expires_at' => $invitation->expires_at->toISOString(),
            ]
        ]);
    }

    /**
     * Révoquer une invitation
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        if (!$user->compagny || $user->compagny->owner_id !== $user->id) {
            return response()->json([
                'message' => 'Non autorisé.'
            ], 403);
        }

        $invitation = CompanyInvitation::where('id', $id)
            ->where('compagny_id', $user->compagny->id)
            ->first();

        if (!$invitation) {
            return response()->json(['message' => 'Invitation introuvable.'], 404);
        }

        $invitation->delete();

        return response()->json([
            'message' => 'Invitation révoquée avec succès.'
        ]);
    }

    /**
     * Accepter une invitation (route publique)
     */
    public function accept(Request $request, $token)
    {
        $invitation = CompanyInvitation::where('token', $token)->first();

        if (!$invitation) {
            return response()->json([
                'message' => 'Invitation invalide.'
            ], 404);
        }

        if ($invitation->accepted_at) {
            return response()->json([
                'message' => 'Cette invitation a déjà été acceptée.'
            ], 422);
        }

        if ($invitation->isExpired()) {
            return response()->json([
                'message' => 'Cette invitation a expiré.'
            ], 422);
        }

        // Retourner les informations pour l'inscription
        return response()->json([
            'data' => [
                'email' => $invitation->email,
                'user' => $invitation->user ? [
                    'id' => $invitation->user->id,
                    'firstname' => $invitation->user->firstname,
                    'name' => $invitation->user->name,
                    'email' => $invitation->user->email,
                    'phoneNumber' => $invitation->user->phoneNumber,
                ] : null,
                'company' => [
                    'id' => $invitation->compagny->id,
                    'name' => $invitation->compagny->name,
                ],
                'token' => $invitation->token,
            ]
        ]);
    }

    /**
     * Accepter une invitation (utilisateur existant)
     */
    public function acceptInvitation(Request $request, $token)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Vous devez être connecté pour accepter une invitation.'
            ], 401);
        }

        $invitation = CompanyInvitation::where('token', $token)
            ->where('email', $user->email)
            ->first();

        if (!$invitation) {
            return response()->json([
                'message' => 'Invitation introuvable ou non autorisée.'
            ], 404);
        }

//        if ($invitation->accepted_at) {
//            return response()->json([
//                'message' => 'Cette invitation a déjà été traitée.'
//            ], 422);
//        }

        if ($invitation->isExpired()) {
            return response()->json([
                'message' => 'Cette invitation a expiré.'
            ], 422);
        }

        // Accepter l'invitation
        $user->update(['compagny_id' => $invitation->compagny_id, 'role' => UserRole::RECRUITER]);
        $invitation->markAsAccepted();

        return response()->json([
            'message' => 'Invitation acceptée avec succès !',
            'data' => [
                'company' => [
                    'id' => $invitation->compagny->id,
                    'name' => $invitation->compagny->name,
                ]
            ]
        ]);
    }

    /**
     * Décliner une invitation (utilisateur existant)
     */
    public function declineInvitation(Request $request, $token)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Vous devez être connecté pour décliner une invitation.'
            ], 401);
        }

        $invitation = CompanyInvitation::where('token', $token)
            ->where('email', $user->email)
            ->first();

        if (!$invitation) {
            return response()->json([
                'message' => 'Invitation introuvable ou non autorisée.'
            ], 404);
        }

        if ($invitation->status !== 'pending') {
            return response()->json([
                'message' => 'Cette invitation a déjà été traitée.'
            ], 422);
        }

        $invitation->markAsDeclined();

        return response()->json([
            'message' => 'Invitation déclinée.'
        ]);
    }

    /**
     * Retirer un recruteur de l'entreprise
     */
    public function removeRecruiter(Request $request, $recruiterId)
    {
        $user = $request->user();

        // Vérifier que l'utilisateur est owner
        if (!$user->compagny || $user->compagny->owner_id !== $user->id) {
            return response()->json([
                'message' => 'Seul le propriétaire de l\'entreprise peut retirer des recruteurs.'
            ], 403);
        }

        $recruiter = User::find($recruiterId);

        if (!$recruiter) {
            return response()->json(['message' => 'Recruteur introuvable.'], 404);
        }

        // Vérifier que le recruteur appartient à cette entreprise
        if ($recruiter->compagny_id !== $user->compagny->id) {
            return response()->json([
                'message' => 'Ce recruteur ne fait pas partie de votre entreprise.'
            ], 422);
        }

        // Empêcher le propriétaire de se retirer lui-même
        if ($recruiter->id === $user->id) {
            return response()->json([
                'message' => 'Vous ne pouvez pas vous retirer vous-même de l\'entreprise.'
            ], 422);
        }

        // Retirer le recruteur
        $recruiter->update(['compagny_id' => null]);

        return response()->json([
            'message' => 'Recruteur retiré de l\'entreprise avec succès.'
        ]);
    }
}
