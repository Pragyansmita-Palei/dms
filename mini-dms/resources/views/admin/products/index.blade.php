<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Products</title>
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
            <h1 class="text-2xl font-bold mb-4">Products</h1>

            <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded mb-4 inline-block">Add Product</a>

            @if(session('success'))
                <div class="mt-2 text-green-600">{{ session('success') }}</div>
            @endif

            <!-- Responsive table wrapper -->
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full bg-white border-collapse border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border border-gray-300 px-2 py-1 text-left">ID</th>
                            <th class="border border-gray-300 px-2 py-1 text-left">Name</th>
                            <th class="border border-gray-300 px-2 py-1 text-left">Price</th>
                            <th class="border border-gray-300 px-2 py-1 text-left">Stock</th>
                            <th class="border border-gray-300 px-2 py-1 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $p)
                        <tr class="border-b">
                            <td class="border border-gray-300 px-2 py-1">{{ $p->id }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $p->name }}</td>
                            <td class="border border-gray-300 px-2 py-1">₹{{ $p->price }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $p->stock }}</td>
                            <td class="border border-gray-300 px-2 py-1 flex flex-wrap gap-2">
                                <a href="{{ route('admin.products.edit', $p) }}" class="px-2 py-1 bg-yellow-400 rounded text-sm">Edit</a>
                                <form action="{{ route('admin.products.destroy', $p) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-2 py-1 bg-red-500 text-white rounded text-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>

</body>
</html>
