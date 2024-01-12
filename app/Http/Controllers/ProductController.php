<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class ProductController extends Controller
{
    public function all_product(){
        $products = Product::orderBy('id', 'DESC')->get();
        return response()->json([
            'products' => $products
        ], 200);
    }



}
