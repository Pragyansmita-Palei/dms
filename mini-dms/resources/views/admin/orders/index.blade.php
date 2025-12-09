<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('overlay').classList.toggle('hidden');
        }
    </script>
    <!-- Google Material Icons CDN -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="bg-gray-100 flex min-h-screen">

    <!-- Sidebar -->
    @include('admin.sidebar')

    <!-- Main content -->
    <div class="flex-1 flex flex-col md:ml-64">

            @include('admin.header')


        <div class="container mx-auto p-4">
            <h1 class="text-2xl mb-4 font-bold">Orders</h1>

            @if(session('success'))
                <div class="text-green-600 mb-2">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="text-red-600 mb-2">{{ session('error') }}</div>
            @endif

            <!-- Responsive table wrapper -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border-collapse border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border border-gray-300 px-2 py-1 text-left">ID</th>
                            <th class="border border-gray-300 px-2 py-1 text-left">User</th>
                            <th class="border border-gray-300 px-2 py-1 text-left">Total</th>
                            <th class="border border-gray-300 px-2 py-1 text-left">Status</th>
                            <th class="border border-gray-300 px-2 py-1 text-left">Paid</th>
                            <th class="border border-gray-300 px-2 py-1 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $o)
                        <tr class="border-b">
                            <td class="border border-gray-300 px-2 py-1">{{ $o->id }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $o->user->name }} ({{ $o->user->email }})</td>
                            <td class="border border-gray-300 px-2 py-1">₹{{ $o->total }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $o->status }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $o->is_paid ? 'Yes' : 'No' }}</td>
                            <td class="border border-gray-300 px-2 py-1 space-y-1">
                                <div class="flex flex-wrap gap-1">
                                    <form action="{{ route('admin.orders.approve',$o) }}" method="POST">
                                        @csrf
                                        <button class="px-2 py-1 bg-green-500 text-white rounded text-sm">Approve</button>
                                    </form>

                                    <form action="{{ route('admin.orders.reject',$o) }}" method="POST">
                                        @csrf
                                        <button class="px-2 py-1 bg-red-500 text-white rounded text-sm">Reject</button>
                                    </form>

                                    <form action="{{ route('admin.orders.status',$o) }}" method="POST">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="px-2 py-1 border rounded text-sm">
                                            <option value="">Change status</option>
                                            {{-- <option value="Processing">Processing</option> --}}
                                            <option value="Dispatched">Dispatched</option>
                                            <option value="Delivered">Delivered</option>
                                        </select>
                                    </form>

                                    <form action="{{ route('admin.orders.markpaid',$o) }}" method="POST">
                                        @csrf
                                        <button class="px-2 py-1 bg-blue-500 text-white rounded text-sm">Mark Paid</button>
                                    </form>
                                </div>

                                <div class="mt-2 text-sm">
                                    <strong>Items:</strong>
                                    <ul class="list-disc ml-5">
                                        @foreach($o->items as $it)
                                            <li>{{ $it->product->name ?? 'Deleted' }} × {{ $it->quantity }} (₹{{ $it->price }})</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

</body>
</html>
