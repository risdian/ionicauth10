<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'order_number', 'user_id', 'status', 'grand_total', 'item_count', 'sub_total', 'tax', 'delivery_method','delivery_price',
        'payment_status',
        'payment_method',
        'payment_code',
        'payment_datetime',
        'payment_transaction_id',
        'name', 'address', 'city', 'state', 'country', 'postcode', 'phone_number', 'notes', 'email',


    ];

    public static function getOrder(){

        // $records = DB::table('orders')->select('id',
        // 'order_number', 'user_id', 'status', 'grand_total', 'item_count', 'sub_total', 'tax', 'delivery_method','delivery_price',
        // 'payment_status',
        // 'payment_method',
        // 'payment_code',
        // 'payment_datetime',
        // 'payment_transaction_id',
        // 'name', 'address', 'city', 'state', 'country', 'postcode', 'phone_number', 'notes', 'email',)->orderBy('id', 'asc')->get()->toArray();

        $records = Order::with('products')->get();

        return $records;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // public function orderItem(){

    //     return $this->belongsToMany(Product::class);

    // }

    public function products(){

        return $this->belongsToMany(Product::class)->withPivot(['id', 'price', 'quantity', 'tracking_status', 'tracking_number', 'tracking_datetime'])->withTimestamps();

    }

}
