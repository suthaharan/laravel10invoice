<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).
- [Vuetify with Laravel](https://medium.com/@hafizzeeshan619/setting-up-laravel-10-with-vue3-and-vuetify3-26de92235baa)

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Setting up Laravel

$ docker exec -u 0 -it laravel-ambassdor-web bash

#### The project involves creating a invoice generation system adopted from https://github.com/share-tutorials-dev

* [Video tutorial](https://www.youtube.com/watch?v=_MZ1B5F2PFc)
```
php artisan --version
php artisan route:list
composer create laravel/laravel invoice
cd invoice
php artisan key:generate --ansi
php artisan serve
```
Error: /storage could not be opened in append mode: Failed to open stream
sudo chmod -R ugo+rw storage


=> create a database invoice-db
=> Modify the .env file to set the database credentials
```
php artisan make:model Counter -m 
(Modify the migrations file for respective fields)
php artisan migrate
php artisan make:factory CounterFactory
php artisan db:seed

php artisan make:model Product -mc
(Modify the migrations file for respective fields)
php artisan migrate
php artisan make:factory ProductFactory
php artisan db:seed


php artisan make:model Customer -mc
(Modify the migrations file for respective fields)
php artisan migrate
php artisan make:factory CustomerFactory
php artisan db:seed

php artisan make:model Invoice -mc
(Modify the migrations file for respective fields)
php artisan migrate
php artisan make:factory InvoiceFactory
Modify the factory method to feed in faker data)
php artisan db:seed

php artisan make:model InvoiceItem -mc
(Modify the migrations file for respective fields)
php artisan migrate
php artisan make:factory InvoiceItemFactory
Modify the factory method to feed in faker data)
php artisan db:seed
```

## Let's start with Vuejs 3
```
$ apt-get update
$ apt-get install nodejs npm
$ cd /var/www/invoice
$ npm install
$ npm install vue-loader@next vue@next vue-router@next --force
$ npm install @vitejs/plugin-vue --force --save-dev
$ npm run dev
```

Edit vite.config.js

```
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
});

```
* In the /public folder there will be a hot file (for hot reloading) that will be created for build purpose when 'npm run build' is executed. For production mode, you need to remove the file.

Error: /storage could not be opened in append mode: Failed to open stream
sudo chmod -R ugo+rw storage


### Roles, Permissions



composer require spatie/laravel-permission
composer require laravelcollective/html

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

composer require laravel/ui
php artisan ui bootstrap --auth
npm install
npm run build

---


composer require laravel/breeze --dev
php artisan breeze:install vue (installing vue)
npm install
php artisan migrate (to migrate the table if you have not done so early. set the env file prior it)
npm run build
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan optimize:clear (or php artisan config:clear)
php artisan migrate
**app/Http/Models/Role.php**
<?php

namespace App\Models;

use Spatie\Permission\Models\Role as OriginalRole;
class Role extends OriginalRole
{
    protected $fillable = [
        'name',
        'guard_name',
        'updated_at',
        'created_at'
    ]
}

**app/Http/Models/Permission.php**
<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as OriginalPermission;
class Permission extends OriginalPermission
{
    protected $fillable = [
        'name',
        'guard_name',
        'updated_at',
        'created_at'
    ]
}

$ php artisan migrate
$ php artisan make:model Post --migration

```
// Setup HasRoles trait
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

```

// Modify web.php
```
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function(){
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
    'prefix' => 'admin',
    'middleware' => ['auth'],
], function () {
    Route::resource('user', 'UserController');
    Route::resource('role', 'RoleController');
    Route::resource('permission', 'PermissionController');
    Route::resource('post', 'PostController');
});

```

// Make the folder /app/Http/Controllers/Admin/UserController.php
```
<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('can:user_list', ['only' => ['index', 'show']]);
        $this->middleware('can:user_create', ['only' => ['create', 'store']]);
        $this->middleware('can:user_edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:user_delete', ['only' => ['destroy']]);
    }

    public function index(){
        $users = (new User)->newQuery();
        $users->latest();
        $users = $users->paginate(100)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Admin/User/Index', [
            'users' => $users,
            'can' => [
                'create' => Auth::user()->can('user_create'),
                'edit' => Auth::user()->can('user_edit'),
                'delete' => Auth::user()->can('user_delete'),
            ]
        ])
    }
}


```



// Make the folder /app/Http/Controllers/Admin/RoleController.php
```
<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('can:role_list', ['only' => ['index', 'show']]);
        $this->middleware('can:role_create', ['only' => ['create', 'store']]);
        $this->middleware('can:role_edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:role_delete', ['only' => ['destroy']]);
    }

    public function index(){
        $roles = (new Role)->newQuery();
        $roles->latest();
        $roles = $roles->paginate(100)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Admin/Role/Index', [
            'roles' => $roles,
            'can' => [
                'create' => Auth::user()->can('role_create'),
                'edit' => Auth::user()->can('role_edit'),
                'delete' => Auth::user()->can('role_delete'),
            ]
        ])
    }
}


```



// Make the folder /app/Http/Controllers/Admin/PermissionController.php
```
<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PermissionController extends Controller
{
    public function __construct(){
        $this->middleware('can:permission_list', ['only' => ['index', 'show']]);
        $this->middleware('can:permission_create', ['only' => ['create', 'store']]);
        $this->middleware('can:permission_edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:permission_delete', ['only' => ['destroy']]);
    }

    public function index(){
        $permissions = (new Permission)->newQuery();
        $permissions->latest();
        $permissions = $permissions->paginate(100)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Admin/Role/Index', [
            'permissions' => $permissions,
            'can' => [
                'create' => Auth::user()->can('permission_create'),
                'edit' => Auth::user()->can('permission_edit'),
                'delete' => Auth::user()->can('permission_delete'),
            ]
        ])
    }
}
```

//app/Http/Controllers/Admin/PostController.php
```
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:post list', ['only' => ['index', 'show']]);
        $this->middleware('can:post create', ['only' => ['create', 'store']]);
        $this->middleware('can:post edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:post delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = (new Post)->newQuery();
        $posts->latest();
        $posts = $posts->paginate(100)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Admin/Post/Index', [
            'posts' => $posts,
            'can' => [
                'create' => Auth::user()->can('post create'),
                'edit' => Auth::user()->can('post edit'),
                'delete' => Auth::user()->can('post delete'),
            ]
        ]);
    }
}


```




