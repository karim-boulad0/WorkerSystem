<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\post\PostController;
use App\Http\Controllers\Dashboard\order\ClientOrderController;
use App\Http\Controllers\WebSite\Review\WorkerReviewController;
use App\Http\Controllers\Dashboard\worker\WorkerProfileController;
use App\Http\Controllers\Dashboard\worker\WorkerNotificationController;
use App\Http\Controllers\Auth\{AdminController, WorkerController, ClientController};
use App\Http\Controllers\Dashboard\admin\{PostStatusController, AdminNotificationController};
use App\Http\Controllers\WebSite\Order\OrderController;
use App\Http\Controllers\WebSite\Post\PostController as PostPostController;

/************   Auth Routes  ************/

Route::prefix('auth/')->group(function () {

    //  admin
    Route::controller(AdminController::class)->prefix('admin')->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile', 'userProfile');
    });
    // worker
    Route::controller(WorkerController::class)->prefix('worker')->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile', 'userProfile');
        Route::get('/verify/{token}', 'verify');
    });
    // client
    Route::controller(ClientController::class)->prefix('client')->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile', 'userProfile');
    });
});
Route::get('unauthorized', function () {
    return response()->json([
        'message' => 'Unauthorized'
    ], 401);
})->name('login');

/************   Dashboard routes ************/

Route::prefix('/dashboard')->group(function () {

    //  posts
    Route::prefix('/post')->group(function () {
        Route::controller(PostController::class)->group(function () {
            Route::post('/worker/add', 'store')->middleware('auth:worker');
            Route::get('/approved', 'approved')->middleware('auth:worker');
            Route::get('/filterOfApproved', 'filterOfApproved')->middleware('auth:worker');
            Route::get('/filterApprovedByAll', 'filterApprovedByAll')->middleware('auth:worker');
            Route::get('/show', 'index')->middleware('auth:admin');
            Route::get('/getById/{id}', 'getById')->middleware('auth:admin');
        });
    });
    // admin Notifications
    Route::prefix('/admin/notification')->middleware('auth:admin')->group(function () {
        Route::controller(AdminNotificationController::class)->group(function () {
            Route::get('/all',  'index');
            Route::get('/unreadNotifications',  'unreadNotifications');
            Route::post('/markAllAsRead',  'markAllAsRead');
            Route::post('/markAsReadById/{id}',  'markAsReadById');
            Route::delete('/deleteAll',  'deleteAll');
            Route::delete('/deleteById/{id}',  'deleteById');
        });
    });
    // worker Notifications
    Route::prefix('/worker/notification')->middleware('auth:worker')->group(function () {
        Route::controller(WorkerNotificationController::class)->group(function () {
            Route::get('/all',  'index');
            Route::get('/unreadNotifications',  'unreadNotifications');
            Route::post('/markAllAsRead',  'markAllAsRead');
            Route::post('/markAsReadById/{id}',  'markAsReadById');
            Route::delete('/deleteAll',  'deleteAll');
            Route::delete('/deleteById/{id}',  'deleteById');
        });
    });
    // access admin on approved and rejected posts
    Route::post('/admin/post/changeStatus', [
        PostStatusController::class, 'changeStatus'
    ])->middleware('auth:admin');

    Route::prefix('/order')->group(function () {
        Route::controller(ClientOrderController::class)->group(function () {
            //  order of client  {client use it }
            Route::prefix('/client')->group(function () {
                Route::post('/addOrder', 'addOrder')->middleware('auth:client'); // client
            });
            //  change order of clients  {worker use it }
            Route::prefix('/worker')->middleware('auth:worker')->group(function () {
                Route::get('/workerOrders', 'workerOrders'); // worker here
                Route::get('/getById/{id}', 'getById'); // worker here
                Route::post('/update/{id}', 'update'); // worker here
                Route::delete('/delete/{id}', 'delete'); // worker here
            });
        });
    });



    // profile of workers
    Route::controller(WorkerProfileController::class)->group(function () {
        Route::get('/worker/profile', 'profile')->middleware('auth:worker');
        Route::get('/worker/edit', 'edit')->middleware('auth:worker');
        Route::post('/worker/update', 'update')->middleware('auth:worker');
        Route::delete('/worker/deletePosts', 'delete')->middleware('auth:worker');
    });
});


/************   WebSite routes ************/


Route::prefix('webSite/')->group(function () {
    // worker reviews
    Route::controller(WorkerReviewController::class)->group(function () {
        Route::post('/review', 'store')->middleware('auth:client');
        Route::get('/review/post/{postId}', 'postRate');
    });
    // orders
    Route::prefix('/order')->group(function () {
        Route::controller(OrderController::class)->group(function () {
            Route::prefix('/client')->group(function () {
                Route::post('/addOrder', 'addOrder')->middleware('auth:client');
                Route::delete('/delete/{id}', 'delete')->middleware('auth:client');
            });
        });
    });
    // posts
    Route::prefix('/post')->group(function () {
        Route::controller(PostPostController::class)->group(function () {
            Route::get('/posts', 'index');
        });
    });
});
