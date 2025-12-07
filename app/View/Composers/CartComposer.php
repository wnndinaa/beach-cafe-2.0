<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Support\Facades\Auth;

class CartComposer
{
    public function compose(View $view)
    {
        $userId =  Auth::id(); // Get the authenticated user ID
        $pendingOrder = Order::where('user_id', $userId)->where('order_status', 'pending')->first();

        $cartItemCount = $pendingOrder ? OrderItems::where('order_id', $pendingOrder->id)->count() : 0;

        $view->with('cartItemCount', $cartItemCount);
    }
}