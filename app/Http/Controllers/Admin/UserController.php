<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:user_list', ['only' => ['index', 'show']]);
        $this->middleware('can:user_create', ['only' => ['create', 'store']]);
        $this->middleware('can:user_edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:user_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = (new User)->newQuery();
        $users->latest();
        $users = $users->paginate(10)->appends(request()->query());

        return Inertia::render('Admin/User/Index', [
            'users' => $users,
            'can' => [
                'create' => Auth::user()->can('user_create'),
                'edit' => Auth::user()->can('user_edit'),
                'delete' => Auth::user()->can('user_delete'),
            ]
        ]);
    }
}
