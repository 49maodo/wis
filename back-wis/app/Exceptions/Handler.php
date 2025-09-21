<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected function unauthenticated($request, AuthenticationException $exception): Response|JsonResponse|RedirectResponse
    {
        // Pour les requêtes API, retourner JSON
        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated.'
            ], 401);
        }

        // Pour les requêtes web, rediriger vers Filament
        return redirect()->guest(route('filament.admin.auth.login'));
    }
    public function render($request, Throwable $e): Response|JsonResponse|RedirectResponse
    {
        if (($request->is('api/*') || $request->wantsJson()) && $e instanceof AuthorizationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cette action n\'est pas autorisée.'
            ], 403);
        }
        // Gestion des erreurs de validation pour l'API
        if (($request->is('api/*') || $request->expectsJson()) && $e instanceof ValidationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Les données fournies sont invalides.',
                'errors' => $e->errors()
            ], 422);
        }
        // Pour les autres erreurs API, retourner JSON au lieu de HTML
        if ($request->is('api/*') || $request->expectsJson()) {
            // Si c'est une erreur d'authentification qui n'a pas été gérée par unauthenticated()
            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            // Pour les autres erreurs, utiliser le rendu parent, mais forcer JSON
            return parent::render($request, $e);
        }
        // Pour les requêtes web (Filament), rediriger vers login si non authentifié
        if ($e instanceof AuthenticationException) {
            return redirect()->guest(route('filament.admin.auth.login'));
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
