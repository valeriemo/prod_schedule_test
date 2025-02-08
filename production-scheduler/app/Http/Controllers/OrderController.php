<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnCallback;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
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
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
