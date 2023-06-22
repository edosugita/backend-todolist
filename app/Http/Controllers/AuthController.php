<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use App\Validators\UserValidator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class AuthController extends Controller
{
    public function createUser(Request $request)
    {
        if ($request->isMethod('POST')) {
            try {
                $email = $request->email;

                if (Auth::where('email', $email)->exists()) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Email already axist',
                    ], 400);
                } else {
                    $validator = new UserValidator($request->all());

                    if ($validator->validateRegister()) {
                        $userCreate = Auth::create([
                            'uuid' => Uuid::uuid4(),
                            'name' => $request->name,
                            'email' => $email,
                            'password' => Hash::make($request->password),
                            'status' => $request->status,
                        ]);

                        return response()->json([
                            'status' => 201,
                            'message' => 'Success create user',
                            'data' => $userCreate,
                        ], 201);
                    } else {
                        return response()->json([
                            'status' => 422,
                            'errors' => $validator->errors()
                        ], 422);
                    }
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

    public function updateUser(Request $request, $uuid)
    {
        if ($request->isMethod('PUT')) {
            $email = $request->email;
            $user = Auth::where('uuid', $uuid)->first();

            if (!$user) {
                return response()->json([
                    'status' => 404,
                    'message' => 'User anot found',
                ], 404);
            } else {
                if ($email !== $user->email && Auth::where('email', $email)->exists()) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Email already exists',
                    ], 400);
                } else {
                    $validator = new UserValidator($request->all());

                    if ($validator->validateUpdate()) {
                        $user->name = $request->name;
                        $user->email = $email;
                        $user->status = $request->status;
                        $user->save();

                        return response()->json([
                            'status' => 201,
                            'message' => 'Success update data user',
                            'data' => $user,
                        ], 201);
                    } else {
                        return response()->json([
                            'status' => 422,
                            'errors' => $validator->errors()
                        ], 422);
                    }
                }
            }
        } else {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }
    }

    public function updatePasswordUser(Request $request, $uuid)
    {
        if ($request->isMethod('PUT')) {
            $user = Auth::where('uuid', $uuid)->first();

            if (!$user) {
                return response()->json([
                    'status' => 404,
                    'message' => 'User anot found',
                ], 404);
            } else {
                $validator = new UserValidator($request->all());
                
                if ($validator->validateUpdatePassword()) {
                    $oldPassword = $request->old_password;

                    if (Hash::check($oldPassword, $user->password)) {
                        $user->password = Hash::make($request->password);
                        $user->save();
    
                        return response()->json([
                            'status' => 201,
                            'message' => 'Success update password user',
                            'data' => $user,
                        ], 201);
                    } else {
                        return response()->json([
                            'status' => 422,
                            'message' => 'The old password you entered is incorrect.',
                        ], 422);
                    }
                } else {
                    return response()->json([
                        'status' => 422,
                        'errors' => $validator->errors()
                    ], 422);
                }
            }
        } else {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed'
            ], 405);
        }
    }

    public function deleteUser(Request $request, $uuid)
    {
        if ($request->isMethod('DELETE')) {
            try {
                $user = Auth::where('uuid', $uuid)->first();

                if ($user) {
                    $user->delete();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Success deleted user',
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Error user not found',
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

    public function getUser(Request $request, $uuid)
    {
        if ($request->isMethod('GET')) {
            try {
                $user = Auth::where('uuid', $uuid)->first();

                if ($user) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Success get user ' . $user->name,
                        'data' => $user
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Error user not found',
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

    public function getAllUser(Request $request)
    {
        if ($request->isMethod('GET')) {
            try {
                $user = Auth::get();

                if ($user) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Success get all user',
                        'data' => $user
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Error user not found',
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
