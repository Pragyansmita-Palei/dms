<!-- Header/Navbar -->
<nav class="bg-white shadow p-4 flex justify-between items-center">
    <!-- Hamburger for mobile -->
    <button class="md:hidden px-2 py-1 bg-gray-200 rounded" onclick="toggleSidebar()">☰</button>
    <h1 class="text-xl font-bold md:hidden">Admin Panel</h1>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Logout</button>
    </form>
</nav>
