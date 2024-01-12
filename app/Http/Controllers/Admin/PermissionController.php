<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:permission_list', ['only' => ['index', 'show']]);
        $this->middleware('can:permission_create', ['only' => ['create', 'store']]);
        $this->middleware('can:permission_edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:permission_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = (new Permission)->newQuery();
        $permissions->latest();
        $permissions = $permissions->paginate(100)->appends(request()->query());

        return Inertia::render('Admin/Permission/Index', [
            'permissions' => $permissions,
            'can' => [
                'create' => Auth::user()->can('permission_create'),
                'edit' => Auth::user()->can('permission_edit'),
                'delete' => Auth::user()->can('permission_delete'),
            ]
        ]);
    }
}
