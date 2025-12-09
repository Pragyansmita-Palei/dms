<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // list customer's orders
    public function index()
    {
        $orders = auth()->user()->orders()->with('items.product','transaction')->orderBy('created_at','desc')->get();
        $products = Product::where('stock','>=',0)->get();
        return view('customer.orders.index', compact('orders','products'));
    }

    // store order
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.qty' => 'required|integer|min:1'
        ]);

        $items = $data['items'];

        $total = 0;
        $onHold = false;

        foreach ($items as $it) {
            $product = Product::find($it['product_id']);
            if ($product->stock < $it['qty']) {
                $onHold = true;
            }
            $total += $product->price * $it['qty'];
        }

        // create order
        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'status' => $onHold ? 'On Hold' : 'Pending',
                'is_paid' => false
            ]);

            foreach ($items as $it) {
                $product = Product::find($it['product_id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $it['qty'],
                    'price' => $product->price
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error','Failed to create order');
        }

        return redirect()->route('customer.orders.index')->with('success','Order placed');
    }
}
