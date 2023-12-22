<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Worker;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\WorkerService\WorkerLoginService;
use App\Services\WorkerService\WorkerRegisterService;

class WorkerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:worker', ['except' => ['login', 'register', 'verify']]);
    }


    public function login(LoginRequest $request)
    {
        return (new WorkerLoginService())->login($request);
    }


    public function register(RegisterRequest $request)
    {
        return (new WorkerRegisterService())->register($request);
    }


    public function verify($token)
    {
        $user = Worker::where('verification_token', $token)->first();

        if ($user) {
            $user->verification_token = null;
            $user->verified_at = now();
            $user->status = 1;
            $user->save();

            return response()->json([
                'message' => 'User verified successfully',
                'user' => $user
            ]);
        } else {
            return response()->json([
                'error' => 'Invalid token'
            ], 404); // or appropriate HTTP status code for not found
        }
    }



    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }


    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }


    public function userProfile()
    {
        return response()->json(auth()->guard('worker')->user());
    }


    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->guard('worker')->user()
        ]);
    }
}
