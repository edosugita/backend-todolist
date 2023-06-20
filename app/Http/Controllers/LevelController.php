<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Level;
use App\Validators\UserValidator;
use Exception;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function createStatusLevel(Request $request)
    {
        if ($request->isMethod('POST')) {
            try {
                $validator = new UserValidator($request->all());

                if ($validator->validateLevel()) {
                    $levels = Level::create([
                        'name' => $request->name,
                        'kode' => Str::upper(Str::random(4))
                    ]);

                    return response()->json([
                        'status' => 201,
                        'message' => 'Success create role job',
                        'data' => [
                            'name' => $levels->name,
                            'kode' => $levels->kode
                        ]
                    ], 201);
                } else {
                    return response()->json([
                        'status' => 422,
                        'errors' => $validator->errors()
                    ], 422);
                }
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
                'message' => 'Method not allowed'
            ], 405);
        }
    }

    public function updateStatusLevel(Request $request, $kode)
    {
        if ($request->isMethod('PUT')) {
            try {
                $validator = new UserValidator($request->all());

                if ($validator->validateLevel()) {
                    $levels = Level::where('kode', $kode)->first();

                    $levels->name = $request->name;
                    $levels->save();

                    return response()->json([
                        'status' => 201,
                        'message' => 'Success updated role job',
                        'data' => [
                            'name' => $levels->name,
                        ]
                    ], 201);
                } else {
                    return response()->json([
                        'status' => 422,
                        'errors' => $validator->errors()
                    ], 422);
                }
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
                'message' => 'Method not allowed'
            ], 405);
        }
    }

    public function deleteStatusLevel(Request $request, $kode)
    {
        if ($request->isMethod('DELETE')) {
            try {
                $levels = Level::where('kode', $kode)->first();
                
                if ($levels) {
                    $levels->delete();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Success deleted role job',
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Error role not found',
                    ], 404);
                }
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
                'message' => 'Method not allowed'
            ], 405);
        }
    }

    public function getStatusLevel(Request $request, $kode)
    {
        if ($request->isMethod('GET')) {
            try {
                $levels = Level::where('kode', $kode)->first();

                if ($levels) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Success get role ' . $levels->name,
                        'data' => $levels
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Error role not found',
                    ], 404);
                }

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
                'message' => 'Method not allowed'
            ], 405);
        }
    }

    public function getAllStatusLevel(Request $request)
    {
        if ($request->isMethod('GET')) {
            try {
                $levels = Level::get();

                if ($levels) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Success get all role',
                        'data' => $levels
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Error role not found',
                    ], 404);
                }

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
                'message' => 'Method not allowed'
            ], 405);
        }
    }
}
