<?php

namespace App\Http\Controllers\Customer;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Shipped,Delivered'
        ]);

        $order->status = $request->status;
        $order->save();

        // Call the event
        event(new OrderStatusUpdated($order->id, $order->status));

        return response()->json(['success' => true, 'status' => $order->status]);
    }

    
    public function checkout(Request $request)
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        if(!$cart || !$cart->items->count()) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        $total = $cart->items->sum(fn($item) => $item->price * $item->quantity);

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $total,
            'status' => 'pending'
        ]);

        foreach($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price
            ]);
        }
        $cart->items()->delete();
        if ($cart->delete()) {
            Log::info('Cart deletion success for cart id: ' . $cart->id);
        } else {
            Log::error('Cart deletion failed for cart id: ' . $cart->id);
        }

        return redirect()->route('customer.dashboard')->with('success', 'Order placed successfully!');
    }
}
