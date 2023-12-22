<?php

namespace App\Services\WorkerService;

use Exception;
use App\Models\Worker;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Notifications\VerifyEmail;

class WorkerRegisterService
{
    protected $model;
    function __construct()
    {
        $this->model = new Worker();
    }
    function validation($request)
    {
        $validator =   Validator::make($request->all(), $request->rules());

        return $validator;
    }
    function store($data, $request)
    {
        $worker =  $this->model->create(array_merge(
            $data->validated(),
            [
                'password' => bcrypt($request->password),
                'photo' => $request->file('photo')->store("assets"),
            ]
        ));
        return $worker;
    }
    function generateToken($request)
    {
        $token = substr(md5(rand(0, 9) . $request->email . time()), 0, 32);
        $worker = $this->model->where('email', $request->email)->first();
        $worker->verification_token = $token;
        $worker->save();
        return $worker;
    }
    function sendEmail($worker)
    {
        Mail::to('lbkarim25@gmail.com')->send(new VerificationEmail($worker));
    }

    function register($request)
    {
        try {
            DB::beginTransaction();
            $validationData = $this->validation($request);
            if ($validationData->fails()) {
                return response()->json($validationData->errors(), 422);
            }
            // Save worker data to the database
            $store = $this->store($validationData, $request);
            // Generate verification token and update the worker model
            $token = $this->generateToken($request);
            // Send email after saving data to the database
            // $this->sendEmail($token);
            DB::commit();
            return response()->json(['data' => [$token], 'status' => 200]);
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(['error' => $err->getMessage()], 500);
        }
    }
}
