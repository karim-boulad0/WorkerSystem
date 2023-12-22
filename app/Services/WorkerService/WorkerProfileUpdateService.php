<?php

namespace App\Services\WorkerService;

use App\Models\Worker;
use Illuminate\Support\Facades\Storage;

class WorkerProfileUpdateService
{
    protected $model;
    function __construct()
    {
        $this->model = Worker::find(auth()->guard('worker')->id());
    }

    public function photo($request, $worker)
    {
        if ($request->hasFile('photo')) {
            if ($worker->photo) {
                Storage::delete($worker->photo);
            }
            $photo = $request->file('photo');
            $worker->photo = $photo->store('workerProf');
            $data['photo'] = $worker->photo;
            return $data;
        }
    }

    public function password($request)
    {
        if ($request->has('password')) {
            $password = bcrypt($request->password); // Hash the password
            $data['password'] = $password;
        } else {
            $data['password'] = null;
        }
        return $data;
    }
    public function update( $request)
    {
        $data = $request->all();
        $worker = $this->model;
        $data['photo'] = $this->photo($request, $worker);
        $data['password'] = $this->password($request);
        Worker::find($worker->id)->update();
        return response()->json([
            'message' => 'Worker updated successfully',
            'data' => $worker
        ], 200);
    }
}
