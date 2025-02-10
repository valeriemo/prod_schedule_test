<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function create()
    {
        $products = Product::all(); 
        $productTypes = $products->pluck('type')->unique();
        
        return view('orders.create', compact('productTypes', 'products'));
    }

    public function store(OrderRequest $request)
    {
        DB::transaction(function () use ($request) {
            $order = Order::create([
                'need_by_date' => $request->need_by_date
            ]);

            foreach ($request->product_ids as $product_id) {
                if (isset($request->quantities[$product_id])) { 
                    $order->items()->create([
                        'order_id' => $order->id,
                        'product_id' => $product_id,
                        'quantity' => $request->quantities[$product_id]
                    ]);
                }
            }
        });

        return redirect()->route('orders.create')->with('success', 'Order created successfully!');
    }
}
