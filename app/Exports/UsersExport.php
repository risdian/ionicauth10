<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithMapping
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() {

        return Order::query()->with('products')->get();

    }

    /**
    * @var Invoice $invoice
    */
    public function map($user): array
    {
        return [
            $user->id,
            $user->order_number,
            $user->products->map->only('name', 'sku'),
        ];
    }

}
