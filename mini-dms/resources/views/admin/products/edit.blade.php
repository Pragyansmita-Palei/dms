<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('overlay').classList.toggle('hidden');
        }
    </script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="bg-gray-100 flex min-h-screen">

    <!-- Sidebar -->
    @include('admin.sidebar')

    <!-- Main content -->
    <div class="flex-1 flex flex-col md:ml-64">

            @include('admin.header')

        <div class="container mx-auto p-4">
            <h1 class="text-2xl mb-4 font-bold">Edit Product</h1>

            @if(session('success'))
                <div class="text-green-600 mb-2">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="text-red-600 mb-2">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.products.update', $product) }}" method="POST" class="bg-white p-6 rounded shadow-md">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Name</label>
                    <input name="name" value="{{ $product->name }}" class="border p-2 w-full rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Description</label>
                    <textarea name="description" class="border p-2 w-full rounded">{{ $product->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Price</label>
                    <input name="price" value="{{ $product->price }}" type="number" step="0.01" class="border p-2 w-full rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Stock</label>
                    <input name="stock" value="{{ $product->stock }}" type="number" class="border p-2 w-full rounded" required>
                </div>
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Product</button>
            </form>
        </div>

    </div>

</body>
</html>
