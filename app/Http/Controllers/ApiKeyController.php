<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\ApiKey;
use Exception;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    public function makeApiKey(Request $request)
    {
        if ($request->isMethod('POST')) {
            try {
                $apiKey = ApiKey::create([
                    'key' => 'api-key-'.Str::random(40),
                    'is_active' => 1
                ]);

                return response()->json([
                    'status' => 201,
                    'message' => 'Success create api key',
                    'api_keys' => $apiKey->key
                ], 201);
            } catch (Exception $e) {
                return response()->json([
                    'status' => 500,
                    'message' => 'An error occurred while sending the request',
                    'error' => $e
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed',
            ], 405);
        };
    }
}
