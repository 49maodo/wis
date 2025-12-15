<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Compagny;
use App\Models\Profile;
use App\Models\SubscriptionOffer;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Register Candidate
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phoneNumber' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', 'min:5'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'firstname' => $request->firstname,
            'phoneNumber' => $request->phoneNumber,
        ]);

        // create profile
        Profile::create(
            [
                'user_id' => $user->id,
                'slug' => \Str::slug($user->firstname . ' ' . $user->name . '-' . uniqid()),
            ]
        );

        event(new Registered($user));

        return response()->json([
            'status' => 'success',
            'message' => 'Candidate registered successfully',
        ]);
    }

    /**
     * Register Recruiter
     */
    public function storeRecruiter(Request $request): JsonResponse
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phoneNumber' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', 'min:5'],
            'subscription_id' => ['required', 'exists:subscription_offers,id'],
            'compagny_ninea' => ['nullable', 'string', 'max:255'],
            'compagny_rccm' => ['nullable', 'string', 'max:255'],
            'compagny_name' => ['required', 'string', 'max:255'],
        ]);
        try {
            // Check if subscription is free
            $subscriptionOffer = SubscriptionOffer::find($request->subscription_id);

            if (!$subscriptionOffer->isFree()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Only free subscriptions are currently available.',
                ], 403);
            }
            // db begin transaction
            DB::beginTransaction();
            if ($request->filled('compagny_ninea')) {
                $compagny = Compagny::firstOrCreate(
                    ['ninea' => $request->compagny_ninea],
                    [
                        'name' => $request->compagny_name,
                        'ninea' => $request->compagny_ninea,
                        'rccm' => $request->compagny_rccm,
                    ]);
            } else {
                $compagny = Compagny::create([
                    'name' => $request->compagny_name,
                    'ninea' => $request->compagny_ninea,
                    'rccm' => $request->compagny_rccm,
                ]);
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'firstname' => $request->firstname,
                'phoneNumber' => $request->phoneNumber,
                'role' => UserRole::RECRUITER->value,
            ]);
            $user->compagny()->associate($compagny);
            $user->save();

            $subscription = $user->subscriptions()->create([
                'subscription_offer_id' => $request->subscription_id,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'status' => 'active',
            ]);
            // db commit
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Recruteur registered successfully',
            ]);
        } catch (\Exception $e) {
            // rollback transaction
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during registration: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check if NINEA exists and return company data
     */
    public function checkNinea(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ninea' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // TODO: Integrate with actual NINEA API
        // For now, check in database
        $company = Compagny::where('ninea', $request->ninea)->first();

        if ($company) {
            return response()->json([
                'status' => 'success',
                'found' => true,
                'data' => [
                    'compagny_name' => $company->name,
                    'compagny_rccm' => $company->rccm,
                ],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'found' => false,
            'message' => 'Aucune entreprise trouvée avec ce NINEA',
        ]);
    }
}
