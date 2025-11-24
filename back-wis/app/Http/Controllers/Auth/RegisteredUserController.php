<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\CompanyInvitation;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Register
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phoneNumber' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', 'min:5'],
            'role' => ['nullable', 'string', 'in:user,recruiter'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'firstname' => $request->firstname,
            'phoneNumber' => $request->phoneNumber,
            'role' => $request->role ?? 'user',
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
            'message' => 'User registered successfully',
        ]);
    }
}
