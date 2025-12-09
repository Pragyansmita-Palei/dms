<!-- admin/sidebar.blade.php -->
<aside id="sidebar" class="bg-gray-800 text-white w-64 min-h-screen fixed transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-20">
    <div class="p-6 text-2xl font-bold border-b border-gray-700">Admin Panel</div>
    <nav class="p-6 space-y-2">
        <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700' : '' }}">
            <span class="material-icons mr-2">shopping_cart</span>
            Admin Orders
        </a>
        <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.products.*') ? 'bg-gray-700' : '' }}">
            <span class="material-icons mr-2">inventory_2</span>
            Admin Products
        </a>
    </nav>
</aside>

<!-- Overlay for mobile sidebar -->
<div id="overlay" class="fixed inset-0 bg-black opacity-50 hidden z-10 md:hidden" onclick="toggleSidebar()"></div>
