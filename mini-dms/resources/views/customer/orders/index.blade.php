<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="container mx-auto p-4 sm:p-6">

    {{-- Header with Logout --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Your Orders</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Logout</button>
        </form>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded border border-green-200">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    {{-- Place New Order --}}
    <div class="mb-8 p-4 sm:p-6 bg-white rounded shadow-md">
        <h2 class="text-lg sm:text-xl font-semibold mb-4 text-gray-700">Place New Order</h2>
        <form method="POST" action="{{ route('customer.orders.store') }}">
            @csrf
            <div id="items" class="space-y-3">
                <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                    <select name="items[0][product_id]" class="border rounded p-2 flex-1 w-full sm:w-auto">
                        @foreach($products as $p)
                            <option value="{{ $p->id }}">{{ $p->name }} - ₹{{ $p->price }} (Stock: {{ $p->stock }})</option>
                        @endforeach
                    </select>
                    <input name="items[0][qty]" type="number" value="1" min="1" class="border rounded p-2 w-full sm:w-20">
                    <button type="button" onclick="removeRow(this)" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition w-full sm:w-auto">-</button>
                </div>
            </div>
            <div class="mt-4 flex flex-col sm:flex-row gap-3">
                <button type="button" onclick="addRow()"
                    class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 transition w-full sm:w-auto">
                    Add Item
                </button>
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 transition w-full sm:w-auto">
                    Place Order
                </button>
            </div>
        </form>
    </div>

    {{-- Order History --}}
    <h2 class="text-lg sm:text-xl font-semibold mb-4 text-gray-700">Order History</h2>

    <div class="space-y-4">
        @foreach($orders as $o)
            <div class="border rounded p-4 bg-white shadow-sm">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
                    <strong class="text-gray-800 mb-1 sm:mb-0">Order #{{ $o->id }}</strong>
                    <span class="text-gray-600">₹{{ $o->total }}</span>
                </div>
                <div class="mb-2 text-gray-600 text-sm sm:text-base">
                    Status: <span class="font-medium">{{ $o->status }}</span> — Paid: <span class="font-medium">{{ $o->is_paid ? 'Yes' : 'No' }}</span>
                </div>
                <div class="mb-2 text-gray-600 text-sm sm:text-base">
                    <strong class="text-gray-700">Items:</strong>
                    <ul class="list-disc list-inside">
                        @foreach($o->items as $it)
                            <li>{{ $it->product->name ?? 'Deleted' }} × {{ $it->quantity }} (₹{{ $it->price }})</li>
                        @endforeach
                    </ul>
                </div>
                @if(!$o->is_paid)
                    <a href="{{ route('customer.pay',$o) }}" class="inline-block mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition w-full sm:w-auto text-center">Pay Now</a>
                @endif
            </div>
        @endforeach
    </div>
</div>

<script>
let idx = 1;

function addRow() {
    const container = document.getElementById('items');
    const div = document.createElement('div');
    div.className = 'flex flex-col sm:flex-row gap-3 items-start sm:items-center';
    div.innerHTML = `
        <select name="items[${idx}][product_id]" class="border rounded p-2 flex-1 w-full sm:w-auto">
            @foreach($products as $p)
                <option value="{{ $p->id }}">{{ $p->name }} - ₹{{ $p->price }} (Stock: {{ $p->stock }})</option>
            @endforeach
        </select>
        <input name="items[${idx}][qty]" type="number" value="1" min="1" class="border rounded p-2 w-full sm:w-20">
        <button type="button" onclick="removeRow(this)" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition w-full sm:w-auto">-</button>
    `;
    container.appendChild(div);
    idx++;
}

function removeRow(btn){
    btn.parentElement.remove();
}
</script>

</body>
</html>
