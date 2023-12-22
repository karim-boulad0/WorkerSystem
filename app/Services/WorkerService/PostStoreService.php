<?php

namespace App\Services\WorkerService;

use App\Models\Admin;
use Exception;
use App\Models\Post;
use App\Models\PostPhoto;
use App\Notifications\PostNotifications;
use App\Notifications\PostStatusNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class PostStoreService
{
    protected $model;
    function __construct()
    {
        $this->model = new Post();
    }
    public function adminPercent($price)
    {
        $discount = $price * 0.05;
        $priceAfterDiscount = $price - $discount;
        return $priceAfterDiscount;
    }
    function storePost($data)
    {
        $data =  $data->except('photos');
        $priceAfterDiscount = $this->adminPercent($data['price']);
        $data['worker_id'] = auth()->guard('worker')->id();
        $data['price'] = $priceAfterDiscount;
        $post = Post::create($data);
        return $post;
    }

    function storePostPhoto($request, $postId)
    {
        $photos = $request->file('photos');
        foreach ($photos as $photo) {
            $postPhoto = new PostPhoto();
            $postPhoto->post_id = $postId;
            $postPhoto->photo = $photo->store('posts');
            $postPhoto->save();
        }
        return $photos;
    }

    function storePostPhotos($request, $postId)
    {
        $photos = $request->file('photos');
        foreach ($photos as $photo) {
            $postPhotos = new PostPhoto();
            $postPhotos->post_id = $postId;
            $postPhotos->photo = $photo->store('posts');
            $postPhotos->save();
        }
        return $postPhotos;
    }

    function sendAdminNotification($post)
    {
        $admins = Admin::get();
        $worker = auth()->guard('worker')->user();
        $notification = Notification::send($admins, new PostNotifications($worker, $post));
        return $admins;
    }

    function store($request)
    {
        try {
            DB::beginTransaction();
            $post = $this->storePost($request);
            if ($request->hasFile('photos')) {
                $postPhotos = $this->storePostPhotos($request, $post->id);
            }
            $notification =  $this->sendAdminNotification($post);
            DB::commit();
            return response()->json(['data' => $post, 'message' => 'success , your price after discount is  ' . $post->price, 'status' => 200]);
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(['error' => $err->getMessage()], 500);
        }
    }
}
