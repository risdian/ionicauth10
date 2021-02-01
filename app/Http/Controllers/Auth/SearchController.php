<?php

namespace App\Http\Controllers\Auth;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function product(Request $request){

            $search = $request->get('search');

            $products = Product::
                where('name', 'like', '%'.$search.'%')
                ->with('category', 'branch', 'images')
                ->get();

            return response()->json($products);

    }

    public function item_product(Request $request){

            $search = $request->get('search');

            $products = Product::
                where('name', 'like', '%'.$search.'%')
                ->with(
                    array('category', 'branch', 'images' ,'items' => function($query) {
                        $query->where('user_id', Auth()->user()->id);
                    })
                )
                ->get();

            return response()->json($products);

    }

    public function item(Request $request){

        $search = $request->get('search');

        // $products = Item::join('products', 'products.id', '=', 'items.product_id')
        //     ->where('items.user_id',  Auth()->user()->id)
        //     ->where('products.name', 'like', '%'.$search.'%')
        //     ->with('product')->get();


        $products = Product::whereIn('id',
            Item::select('product_id')
            ->where('user_id', Auth()->user()->id)
            ->get())->where('name', 'like', '%'.$search.'%')
            ->with('category', 'branch', 'images')
            ->get();

        // $products = Product::
        // where('name', 'like', '%'.$search.'%')
        // ->with('category', 'branch', 'images')->get();

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
        ->orwhere('phone_number', 'like', '%'.$search.'%')
        ->where('user_id', Auth()->user()->id)
        ->get();

        // $products = Product::where('name', 'like', '%'.$search.'%')->get();

        return response()->json($orders);

    }

    public function invite(Request $request){
        $search = $request->get('search');

        $invite = User::where('parent_id', Auth()->user()->id)
        ->orwhere('name', 'like', '%'.$search.'%')
        ->orwhere('email', 'like', '%'.$search.'%')
        ->orwhere('nric', 'like', '%'.$search.'%')
        ->orwhere('mobile', 'like', '%'.$search.'%')
        ->get();

        return response()->json($invite);

    }
}
