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
        $this->middleware('can:post_list', ['only' => ['index', 'show']]);
        $this->middleware('can:post_create', ['only' => ['create', 'store']]);
        $this->middleware('can:post_edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:post_delete', ['only' => ['destroy']]);
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
        $posts = $posts->paginate(10)->appends(request()->query());

        return Inertia::render('Admin/Post/Index', [
            'posts' => $posts,
            'can' => [
                'create' => Auth::user()->can('post_create'),
                'edit' => Auth::user()->can('post_edit'),
                'delete' => Auth::user()->can('post_delete'),
            ]
        ]);
    }
}
