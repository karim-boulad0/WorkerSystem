/* {{database}}
Worker System
-admins
-workers
-clients
-posts
-posts photo
-orders
-worker reviews
*/

/* {{commend steps}}
-composer require yousefpackage/lara-backup
-we have to make this step that was written  down this line
// [this link's download steps of auth it handle every thing related with user login ,register, create token, refresh token ,showUsers] https://www.positronx.io/laravel-jwt-authentication-tutorial-user-login-signup-api/
 */
/* {{writing steps}}
-make two databases in phpMyAdmin by name (backup - worker)
 */
let MakeNotificationWithDataBase = [];
/*
{command}
-php artisan make:notification AdminPost
-php artisan make:notification NewClientOrder
-php artisan notifications:table
-php artisan migrate
-php artisan make:model Notification -m
*/
let MakeActionPostObserverWhenCreated = [];
/*
{command}
-php artisan make:observer PostObserver --model=Post


{code}
<?php
namespace App\Providers;
use App\Models\Post;
use App\Observers\PostObserver;
use GuzzleHttp\Promise\Create;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
class EventServiceProvider extends ServiceProvider
{
    protected $observers = [
        Post::class => [
            PostObserver::class,
        ],
    ];
    public function boot(): void
    {
        $this->observers;
    }
------------------------
<?php
namespace App\Observers;
use App\Models\Post;
class PostObserver
{
    public function creating(Post $post): void
    {
        $post->status  = 'pending';
    }
*/

let PackageForFilterModel = [];
/**
 * composer require spatie/laravel-query-builder
// GET /users?filter[name]=john&filter[email]=gmail

$users = QueryBuilder::for(User::class)
    ->allowedFilters(['name', 'email'])
    ->get();

// $users wi
 */
