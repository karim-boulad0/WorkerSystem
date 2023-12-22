<?php

namespace App\Http\Controllers\Dashboard\order;

use App\Models\ClientOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderUpdateRequest;

class ClientOrderController extends Controller
{

    // get the orders of current worker
    public function workerOrders()
    {
        $orders = ClientOrder::whereStatus('pending')
            ->with(['Client', 'Post'])
            ->whereHas('Post', function ($query) {
                $query->where('worker_id', auth()->guard('worker')->id());
            })
            ->get();
        return response()->json([
            'data' => $orders,
        ], 200);
    }
    // get the order of current worker by id
    public function getById($id)
    {
        $orders = ClientOrder::find($id)->whereStatus('pending')
            ->with(['Client', 'Post'])
            ->whereHas('Post', function ($query) {
                $query->where('worker_id', '!==', auth()->guard('worker')->id());
            })
            ->first();
        return response()->json([
            'data' => $orders,
        ], 200);
    }
    // change order status  of current worker by id
    public function update($id, OrderUpdateRequest $request)
    {
        $orderById = ClientOrder::find($id)
            ->whereHas('Post', function ($query) {
                $query->where('worker_id', auth()->guard('worker')->id());
            })
            ->first();
        if ($orderById->id != $id) {
            return response()->json(['message' => 'Order not found or invalid access'], 404);
        }
        $orderById->setAttribute('status', $request->status)->save();
        return response()->json(['data' => $orderById, 'message' => 'success update ']);
    }
    // delete order by worker if status  is not approved
    public function delete($id)
    {
        $order = ClientOrder::find($id)
            ->whereHas('Post', function ($query) {
                $query->where('worker_id', auth()->guard('worker')->id());
            })
            ->where('status', '!=', 'approved');
        return !$order &&  'you cannot delete approved orders';
        $order->delete();
        return response()->json([
            'message' => 'delete done',
            'data' => $order,
        ]);
    }
}
