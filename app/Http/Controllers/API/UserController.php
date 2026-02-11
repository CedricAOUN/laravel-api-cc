<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use OpenApi\Attributes as OA;

class UserController extends Controller
{
    #[OA\Post(
        path: '/api/v1/users/register',
        operationId: 'registerUser',
        tags: ['Users'],
        parameters: [new OA\Parameter(ref: '#/components/parameters/AcceptJson')],
        requestBody: new OA\RequestBody(ref: '#/components/requestBodies/UserRegistration'),
        responses: [
            new OA\Response(response: 201, description: 'User created successfully'),
            new OA\Response(response: 422, description: 'Validation Error'),
            new OA\Response(response: 409, description: 'Conflict - User already exists'),
            new OA\Response(response: 500, description: 'Server Error'),
        ]
    )]
    function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255Z|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Check if user already exists
        if (User::where('email', $validated['email'])->exists()) {
            return response()->json(['message' => 'User already exists'], 409);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    #[OA\Post(
        path: '/api/v1/users/login',
        operationId: 'loginUser',
        tags: ['Users'],
        parameters: [new OA\Parameter(ref: '#/components/parameters/AcceptJson')],
        requestBody: new OA\RequestBody(ref: '#/components/requestBodies/UserLogin'),
        responses: [
            new OA\Response(response: 200, description: 'User logged in successfully'),
            new OA\Response(response: 422, description: 'Validation Error'),
        ]
    )]
    function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => $user,
        ]);
    }

    #[OA\Post(
        path: '/api/v1/users/logout',
        operationId: 'logoutUser',
        tags: ['Users'],
        security: [['BearerAuth' => []]],
        parameters: [new OA\Parameter(ref: '#/components/parameters/AcceptJson')],
        responses: [
            new OA\Response(response: 201, description: 'User logged out successfully'),
            new OA\Response(response: 401, description: 'Unauthorised'),
        ]
    )]
    function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => "Logged out successfully"]);
    }
}
