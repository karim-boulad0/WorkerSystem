<?php

namespace App\Services\WorkerService;

use App\Models\Worker;
use Illuminate\Support\Facades\Validator;

class WorkerLoginService
{
    protected $model;
    function __construct()
    {
        $this->model = new Worker();
    }
    function validation($request)
    {
        $validator =   Validator::make($request->all(), $request->rules());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        return $validator;
    }

    function isValidData($data)
    {
        if (!$token = auth()->guard('worker')->attempt($data->validated())) {
            return response()->json(['error' => 'invalid data'], 401);
        }
        return $token;
    }

    function getStatus($email)
    {
        $worker = $this->model->whereEmail($email)->first();
        $status = $worker->status;
        return $status;
    }
    function isVerified($email)
    {
        $worker = $this->model->whereEmail($email)->first();
        $verified_at = $worker->verified_at;
        return $verified_at;
    }

    protected function createToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->guard('worker')->user()
        ]);
    }
    function login($request)
    {
        $data = $this->validation($request);
        $token = $this->isValidData($data);

        if ($this->isVerified($request->email) == null) {
            return response()->json(['message' => 'your account is not verified', 'status' => 200]);
        } elseif ($this->getStatus($request->email) == 0) {
            return response()->json(['message' => 'your account is pending', 'status' => 422]);
        }

        // Return the token response directly, without assigning it to $newToken
        return $this->createToken($token);
    }
}
// <?php

// namespace App\Services\WorkerService\WorkerService;

// use App\Models\Worker;
// use Illuminate\Support\Facades\Validator;

// class WorkerLoginService
// {
//     protected $model;

//     public function __construct()
//     {
//         $this->model = new Worker();
//     }

//     public function validateRequest($request)
//     {
//         $validator = Validator::make($request->all(), $request->rules());
//         return $validator;
//     }

//     public function authenticate($data)
//     {
//         return auth()->guard('worker')->attempt($data->validated());
//     }

//     public function checkVerificationStatus($email)
//     {
//         $worker = $this->model->whereEmail($email)->first();
//         return $worker ? $worker->verified_at : null;
//     }

//     public function checkAccountStatus($email)
//     {
//         $worker = $this->model->whereEmail($email)->first();
//         return $worker ? $worker->status : null;
//     }

//     public function generateAccessTokenResponse($token)
//     {
//         return response()->json([
//             'access_token' => $token,
//             'token_type' => 'bearer',
//             'expires_in' => auth()->factory()->getTTL() * 60,
//             'user' => auth()->guard('worker')->user()
//         ]);
//     }

//     public function login($request)
//     {
//         $validator = $this->validateRequest($request);

//         if ($validator->fails()) {
//             return response()->json($validator->errors(), 422);
//         }

//         $token = $this->authenticate($validator);

//         if (!$token) {
//             return response()->json(['error' => 'Invalid data'], 401);
//         }

//         $email = $request->email;
//         $verificationStatus = $this->checkVerificationStatus($email);
//         $accountStatus = $this->checkAccountStatus($email);

//         if ($verificationStatus === null) {
//             return response()->json(['message' => 'Your account is not verified', 'status' => 200]);
//         }

//         if ($accountStatus == 0) {
//             return response()->json(['message' => 'Your account is pending', 'status' => 422]);
//         }

//         $newToken = $this->generateAccessTokenResponse($token);

//         return $newToken;
//     }
// }
