<?php

namespace App\Repositories;

use App\Models\ClientOrder;
use App\Interfaces\CrudRepoInterface;

class ClientOrderRepository implements CrudRepoInterface
{

    public function store($request)
    {
        $clientId=auth()->guard('client')->id();
        $data = $request->all();
        $data['client_id']=$clientId;
        $order =  ClientOrder::create($data);
        return response()->json([
            'message' => 'success',
            'data' => $order,
        ], 200);
    }
}
