<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // QueryBuilder


class OrderController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::id());
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.order', compact('orders'));
    }

    public static function create($products)
    {
        try {
            DB::transaction(function () use ($products) {
                $order = Order::create([
                    'user_id' => Auth::id(),
                ]);
                // dd($order, $order->id);
                foreach ($products as $product) {
                    OrderDetail::create([
                        'product_id' => $product['id'],
                        'order_id' => $order->id,
                        'quantity' => $product['quantity'],
                    ]);
                }
            }, 2);
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }
    }
}
