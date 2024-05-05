<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::where('email', $request['email'])->first();

        return $this->success(
            [
                'user' => $user,
                'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
            ],
            'Login Success',
            200
        );
    }

    public function register(RegisterUserRequest $request)
    {
        $request->validated($request->all());

        // Create a new user
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        // Generate a token for the newly created user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return a response with the user data and token
        return $this->success(
            [
                'user' => $user,
                'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken,
            ]
        );
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        
        return $this->success([], "Success logout and deleting access token", 200);
    }
}
