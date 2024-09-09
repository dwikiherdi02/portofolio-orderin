<div class="sidebar border border-md-right order-2 order-md-1">
    <div class="offcanvas-md offcanvas-end" tabindex="-1" id="sidebarMenu">
        <div class="offcanvas-body d-md-flex flex-column flex-shrink-0 p-0  overflow-y-auto">
            <a href="{{ route('home') }}" id="logo" class="d-block p-3 text-decoration-none" title="Logo" data-bs-toggle="tooltip" data-bs-placement="right">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="w-100 h-auto">
            </a>
            <hr class="divider-line">
            <ul class="nav nav-pills nav-flush flex-column text-center row-gap-2">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ $isMenu->home ? 'active' : ''}} px-0 py-3 rounded-0 d-flex flex-column" aria-current="page" title="Home">
                        <i class="fa-solid fa-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('order.index') }}" class="nav-link {{ $isMenu->order->wildcard ? 'active' : ''}} px-0 py-3 rounded-0 d-flex flex-column" aria-current="page" title="Order">
                        <i class="fa-solid fa-cart-plus"></i>
                        <span>Order</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('product.index') }}" class="nav-link {{ $isMenu->product->wildcard ? 'active' : ''}} px-0 py-3 rounded-0 d-flex flex-column" aria-current="page" title="Products">
                        <i class="fa-solid fa-box-open"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customer.index') }}" class="nav-link {{ $isMenu->customer->wildcard ? 'active' : ''}} px-0 py-3 rounded-0 d-flex flex-column" aria-current="page"
                        title="Customers">
                        <i class="fa-solid fa-users"></i>
                        <span>Customers</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
