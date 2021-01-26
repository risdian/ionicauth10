<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function product(Request $request){

            $search = $request->get('search');

            $products = Product::where('name', 'like', '%'.$search.'%')->with('category', 'branch', 'images')->get();


            // $products = Product::where('name', 'like', '%'.$search.'%')->get();

            return response()->json($products);

    }

    public function order(Request $request){

        $search = $request->get('search');

        $orders = Order::
        where('order_number', 'like', '%'.$search.'%')
        ->orwhere('name', 'like', '%'.$search.'%')
        ->orwhere('email', 'like', '%'.$search.'%')
        ->orwhere('address', 'like', '%'.$search.'%')
        ->orwhere('state', 'like', '%'.$search.'%')
        ->orwhere('postcode', 'like', '%'.$search.'%')
        ->orwhere('phone_number', 'like', '%'.$search.'%')->get();

        // $products = Product::where('name', 'like', '%'.$search.'%')->get();

        return response()->json($orders);

}
}
