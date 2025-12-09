<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product','user','transaction')->orderBy('created_at','desc')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    // Approve: check stock, decrement stock, set to Processing
    public function approve(Order $order)
    {
        // if already approved or not pending/on hold, block
        if (!in_array($order->status, ['Pending','On Hold'])) {
            return back()->with('error','Order cannot be approved');
        }

        // check stock availability
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            if (!$product || $product->stock < $item->quantity) {
                return back()->with('error', "Insufficient stock for {$product->name}");
            }
        }

        // decrement stock
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            $product->stock -= $item->quantity;
            $product->save();
        }

        $order->status = 'Processing';
        $order->save();

        return back()->with('success','Order approved and moved to Processing');
    }

    public function reject(Order $order)
    {
        $order->status = 'Rejected';
        $order->save();
        return back()->with('success','Order Rejected');
    }

    // Admin can update status to Processing -> Dispatched -> Delivered
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status'=>'required|in:Processing,Dispatched,Delivered']);
        $order->status = $request->status;
        $order->save();

        // notify user (optional) - use notifications later
        return back()->with('success','Status updated');
    }

    // mark paid
    public function markPaid(Order $order)
    {
        $order->is_paid = true;
        $order->save();
        return back()->with('success','Order marked paid');
    }
}
