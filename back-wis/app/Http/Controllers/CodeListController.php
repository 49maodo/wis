<?php

namespace App\Http\Controllers;

use App\Models\CodeList;
use Illuminate\Http\JsonResponse;

class CodeListController extends Controller
{
    /**
     * Récupérer toutes les codeLists (avec cache)
     */
    public function index(): JsonResponse
    {
        $codelists = CodeList::getAllForFrontend();

        return response()->json([
            'success' => true,
            'data' => $codelists,
            'cached_at' => now()->toIso8601String(),
        ]);
    }

    /**
     * Récupérer un code list spécifique par type
     */
    public function getByType(string $type): JsonResponse
    {
        if (!array_key_exists($type, CodeList::TYPES) && $type !== 'Skill') {
            return response()->json([
                'success' => false,
                'message' => 'Type de code list invalide',
            ], 404);
        }

        $items = CodeList::getByType($type);

        return response()->json([
            'success' => true,
            'data' => $items,
            'type' => $type,
        ]);
    }
}
