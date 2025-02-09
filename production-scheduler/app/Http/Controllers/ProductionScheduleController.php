<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;

class ProductionScheduleController extends Controller
{
    public function index()
    {
        $orders = $this->getOrdersByDate();
        $schedule = $this->generateSchedule($orders);

        return view('schedule', compact('schedule'));
    }

    private function getOrdersByDate()
    {
        return Order::with('items.product')->orderBy('need_by_date')->get();
    }

    private function getChangeoverDelay($previousProduct, $currentProduct)
    {
        $changeoverDelay = 30;
        if ($previousProduct === null) {
            return 0;
        }

        return ($previousProduct->type === $currentProduct->type) ? 0 : $changeoverDelay;
    }

    private function calculateProductionTime($product, $quantity)
    {
        if (!$product || $product->production_speed <= 0) {
            return CarbonInterval::seconds(0); 
        }
        $productionSeconds = ($quantity / $product->production_speed) * 3600; 

        return CarbonInterval::seconds($productionSeconds); 
    }
    
    private function generateSchedule($orders){
        $schedule = []; 
        $previousProduct = null;
        $previousEndTime = Carbon::now();
    
        foreach ($orders as $order) {
            $currentItem = $order->items->first();
    
            if (!$currentItem || !$currentItem->product) {
                continue;
            }
    
            $quantity = $currentItem->quantity; 
            $currentProduct = $currentItem->product; 
            $dueDate = $order->need_by_date; 

            $changeoverDelay = CarbonInterval::minutes($this->getChangeoverDelay($previousProduct, $currentProduct));
            $hasChangeoverDelay = $changeoverDelay->totalSeconds > 0;
            $productionTime = $this->calculateProductionTime($currentProduct, $quantity);
    
            $startTime = $previousEndTime->copy()->add($changeoverDelay);
            $endTime = $startTime->copy()->add($productionTime);
    

            $schedule[] = [
                'order_id' => $order->id,
                'product' => $currentProduct->name,
                'quantity' => $quantity,
                'due_date' => Carbon::parse($dueDate)->format('Y-m-d'),
                'production_time' => gmdate("H:i:s", $productionTime->totalSeconds), 
                'start_time' => $startTime->format('H:i:s'), 
                'end_time' => $endTime->format('H:i:s'),
                'has_changeover_delay' => $hasChangeoverDelay,
            ];
    
            $previousProduct = $currentProduct;
            $previousEndTime = $endTime;
        }
    
        return $schedule;
    }

}
