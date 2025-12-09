<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout — Order #{{ $order->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-6 rounded shadow-md w-full max-w-md">

    <div class="mb-4 space-y-1">
        <p><strong>Total:</strong> ₹{{ $order->total }}</p>
        <p><strong>Status:</strong> {{ $order->status }}</p>
    </div>

    <button id="rzp-button" class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
        Pay with Razorpay
    </button>
</div>

<script>
document.getElementById('rzp-button').onclick = function() {
    var options = {
        "key": "{{ env('RAZORPAY_KEY') }}",
        "amount": "{{ intval($order->total * 100) }}", // amount in paise
        "currency": "INR",
        "name": "{{ config('app.name') }}",
        "description": "Order #{{ $order->id }}",
        "order_id": "{{ $razorOrder['id'] }}",
        "handler": function (response){
            // Post payment details to server
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('payment.callback') }}";

            var csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            var paymentId = document.createElement('input');
            paymentId.type = 'hidden';
            paymentId.name = 'razorpay_payment_id';
            paymentId.value = response.razorpay_payment_id;
            form.appendChild(paymentId);

            var orderId = document.createElement('input');
            orderId.type = 'hidden';
            orderId.name = 'razorpay_order_id';
            orderId.value = response.razorpay_order_id;
            form.appendChild(orderId);

            var signature = document.createElement('input');
            signature.type = 'hidden';
            signature.name = 'razorpay_signature';
            signature.value = response.razorpay_signature;
            form.appendChild(signature);

            document.body.appendChild(form);
            form.submit();
        },
        "prefill": {
            "name": "{{ auth()->user()->name }}",
            "email": "{{ auth()->user()->email }}"
        },
        "theme": {
            "color": "#528FF0"
        }
    };

    var rzp = new Razorpay(options);
    rzp.open();
};
</script>

</body>
</html>
