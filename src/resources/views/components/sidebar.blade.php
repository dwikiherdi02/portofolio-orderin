@php

$isMenu = (object) [
    'home' => request()->routeIs('home'),
    'order' => request()->routeIs('order.*'),
    'product' => request()->routeIs('product.*'),
    'customer' => request()->routeIs('customer.*'),
];
@endphp

<div class="sidebar border border-md-right order-2 order-md-1">
    <div class="offcanvas-md offcanvas-end" tabindex="-1" id="sidebarMenu">
        <div class="offcanvas-body d-md-flex flex-column flex-shrink-0 p-0  overflow-y-auto">
            <ul class="nav nav-pills nav-flush flex-column mb-auto text-center overflow-x-hidden">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ $isMenu->home ? 'active' : ''}} px-0 py-3 rounded-0 d-flex flex-column" aria-current="page" title="Home">
                        <i class="fa-solid fa-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('order.index') }}" class="nav-link {{ $isMenu->order ? 'active' : ''}} px-0 py-3 rounded-0 d-flex flex-column" aria-current="page" title="Order">
                        <i class="fa-solid fa-cart-plus"></i>
                        <span>Order</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('product.index') }}" class="nav-link {{ $isMenu->product ? 'active' : ''}} px-0 py-3 rounded-0 d-flex flex-column" aria-current="page" title="Products">
                        <i class="fa-solid fa-box-open"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customer.index') }}" class="nav-link {{ $isMenu->customer ? 'active' : ''}} px-0 py-3 rounded-0 d-flex flex-column" aria-current="page"
                        title="Customers">
                        <i class="fa-solid fa-users"></i>
                        <span>Customers</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
