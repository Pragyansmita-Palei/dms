@if(auth()->check() && auth()->user()->isAdmin())
    <x-nav-link href="{{ route('admin.products.index') }}">Admin Products</x-nav-link>
    <x-nav-link href="{{ route('admin.orders.index') }}">Admin Orders</x-nav-link>
@endif

@if(auth()->check() && auth()->user()->isCustomer())
    <x-nav-link href="{{ route('customer.orders.index') }}">My Orders</x-nav-link>
@endif
