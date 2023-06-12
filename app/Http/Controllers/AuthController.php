<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth:api', [

            'except' => [
                'verify',
                'login',
            ],

        ]);
    }

    public function login()
    {
        if($validator = ValidationService::login())
            return $this->core->setResponse('error', $validator, NULL, false , 400  );

        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials))
            return $this->core->setResponse('error', 'Please check your email or password !', NULL, false , 400  );

        return $this->respondWithToken($token, 'login');
    }

    public function logout()
    {
        auth()->logout();

        return $this->core->setResponse('success', 'Successfully logged out' );
    }

    public function refreshToken()
    {
        return $this->respondWithToken(auth()->refresh(), 'refresh token');
    }

    protected function respondWithToken($token, $action = null)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * config('auth.jwt.expires_in', 60),
        ];

        return $this->core->setResponse('success', "Successfully $action", $data );
    }

}