<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Carbon;

class ProductionScheduleController extends Controller
{

        // ✔ Récupérer les commandes (orders) triées par date (need_by_date).
        // ✔ Calculer le temps de production par produit en fonction de sa vitesse (production_speed).
        // ✔ Gérer les délais de changement (changeover delay) entre les types de produits.
        // ✔ Générer un planning avec les heures de début et de fin pour chaque commande.
        // ✔ **Retourner les données à une vue schedule.blade.php.


        // on va aller chercher les orders par orders->id 
        // on va chercher les items associés a l'orders(id) avec sa quantité et son type

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

    private function calculateProductionTime($product)
    {
        return $product->quantity / $product->production_speed;
    }

    private function generateSchedule($orders){
        $schedule = [];
        $previousProduct = null;
        $previousEndTime = Carbon::now();

        foreach ($orders as $order) {
            $currentItem = $order->items->first();

                // Vérifier si la commande a au moins un item et un produit
            if (!$currentItem || !$currentItem->product) {
                continue; // Passer à l'ordre suivant si aucun produit n'est trouvé
            }

            $currentProduct = $order->items->first()->product;
            $changeoverDelay = $this->getChangeoverDelay($previousProduct, $currentProduct);
            $productionTime = $this->calculateProductionTime($currentProduct);

            $startTime = $previousEndTime->addMinutes($changeoverDelay);
            $endTime = $startTime->addMinutes($productionTime);

            $schedule[] = [
                'order_id' => $order->id,
                'product' => $currentProduct->name,
                'start_time' => $startTime,
                'end_time' => $endTime
            ];

            $previousProduct = $currentProduct;
            $previousEndTime = $endTime;
        }

        return $schedule;

    }

    private function getChangeoverDelay($previousProduct, $currentProduct)
    {
        if ($previousProduct === null) {
            return 0;
        }

        return $previousProduct->type === $currentProduct->type ? 0 : $currentProduct->changeover_delay;
    }

}
