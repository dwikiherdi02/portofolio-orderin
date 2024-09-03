import '../scss/app.scss'

import './bootstrap';

import './form';

import './pages/product';

import './pages/order';

import './pages/customer';

// Import only the Bootstrap components we need
import { Popover } from 'bootstrap';

// Create an example popover
document.querySelectorAll('[data-bs-toggle="popover"]')
.forEach(popover => {
    new Popover(popover)
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

