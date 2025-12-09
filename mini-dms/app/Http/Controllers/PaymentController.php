<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Order;
use App\Models\Transaction;

class PaymentController extends Controller
{
    public function pay(Order $order)
    {
        // Only order owner may pay
        if (auth()->id() !== $order->user_id) abort(403);

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        // create razorpay order
        $razorOrder = $api->order->create([
            'receipt' => 'order_'.$order->id,
            'amount' => intval($order->total * 100), // in paise
            'currency' => 'INR'
        ]);

        // create a transaction record
        $txn = Transaction::create([
            'order_id' => $order->id,
            'amount' => $order->total,
            'order_id_razorpay' => $razorOrder['id'],
            'status' => 'initiated'
        ]);

        return view('payment.checkout', compact('order','razorOrder'));
    }

    public function callback(Request $request)
    {
        // This callback is from client-side handler POST (not razorpay webhook)
        $data = $request->only('razorpay_payment_id','razorpay_order_id','razorpay_signature');

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            $attributes = [
                'razorpay_order_id' => $data['razorpay_order_id'],
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'razorpay_signature' => $data['razorpay_signature'],
            ];

            $api->utility->verifyPaymentSignature($attributes);

            $txn = Transaction::where('order_id_razorpay', $data['razorpay_order_id'])->first();
            if (!$txn) return redirect('/')->with('error','Transaction not found');

            $txn->update([
                'payment_id' => $data['razorpay_payment_id'],
                'signature' => $data['razorpay_signature'],
                'status' => 'success',
                'meta' => $request->all()
            ]);

            $order = $txn->order;
            $order->is_paid = true;
            $order->save();

            return redirect()->route('customer.orders.index')->with('success','Payment successful');
        } catch (\Exception $e) {
            // mark failed
            $txn = Transaction::where('order_id_razorpay', $request->razorpay_order_id)->first();
            if ($txn) $txn->update(['status'=>'failed','meta'=>['error'=>$e->getMessage()]]);
            return redirect()->route('customer.orders.index')->with('error','Payment verification failed');
        }
    }
}
