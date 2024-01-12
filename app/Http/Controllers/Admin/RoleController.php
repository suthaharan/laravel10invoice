<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:role_list', ['only' => ['index', 'show']]);
        $this->middleware('can:role_create', ['only' => ['create', 'store']]);
        $this->middleware('can:role_edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:role_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = (new Role)->newQuery();
        $roles->latest();
        $roles = $roles->paginate(100)->appends(request()->query());

        return Inertia::render('Admin/Role/Index', [
            'roles' => $roles,
            'can' => [
                'create' => Auth::user()->can('role_create'),
                'edit' => Auth::user()->can('role_edit'),
                'delete' => Auth::user()->can('role_delete'),
            ]
        ]);
    }
}
