<?php

namespace App\Http\Controllers\WebSite\Order;


use App\Models\ClientOrder;
use App\Http\Controllers\Controller;
use App\Interfaces\CrudRepoInterface;
use App\Http\Requests\Order\OrderStoreRequest;

class OrderController extends Controller
{
    protected $crudRepo;
    // interface inside it just store
    public function __construct(CrudRepoInterface $crudRepo)
    {
        $this->crudRepo = $crudRepo;
    }
    // choose order by client
    public function addOrder(OrderStoreRequest $request)
    {
        return $this->crudRepo->store($request);
    }
    // get the orders of current client
    public function clientOrders()
    {
        $orders = ClientOrder::with(['Post.Worker'])
            ->whereHas('Post', function ($query) {
                $query->where('client_id', auth()->guard('client')->id());
            })
            ->get();
        return response()->json([
            'data' => $orders,
        ], 200);
    }
    // get the order of current client by id
    public function getById($id)
    {
        $order = ClientOrder::find($id)
            ->with(['Post.Worker'])
            ->whereHas('Post', function ($query) {
                $query->where('client_id', '!==', auth()->guard('client')->id());
            })
            ->first();
        return response()->json([
            'data' => $order,
        ], 200);
    }
    // delete order by client if status isn't approved by worker
    public function delete($id)
    {
        $order = ClientOrder::find($id)
            ->where('client_id', auth()->guard('client')->id())
            ->where('status', '!=', 'approved');
        return !$order &&  'you cannot delete approved orders';
        $order->delete();
        return response()->json([
            'message' => 'delete done',
            'data' => $order,
        ]);
    }
}
