<x-app-layout>
    <div class="card border-0">
        <div class="card-body">
            <div class="col-12 col-lg-8">
                <div class="mb-3 row">
                    <label for="ordered-at" class="col-sm-2 col-form-label fs-mona fs-mona-medium">{{ __('Order No') }}</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="ordered-at" value="{{ $order->order_no }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="ordered-at" class="col-sm-2 col-form-label fs-mona fs-mona-medium">{{ __('Order Date') }}</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="ordered-at" value="{{ $order->ordered_at }}">
                        {{-- <input type="text" readonly class="form-control-plaintext" id="ordered-at" value="{{ $order->created_at }}"> --}}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="ordered-at" class="col-sm-2 col-form-label fs-mona fs-mona-medium">{{ __('Customer') }}</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="ordered-at" value="{{ $order->customer->name }}">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="card border-0">
                        <div class="card-header bg-transparent px-0">
                            <h6 class="m-0 my-2 fs-mona fs-mona-medium">{{ __('Ordered Products') }}</h6>
                        </div>
                        <div class="card-body p-0 table-responsive">
                            <table id="tbl-ordered-product" class="table table-app">
                                <thead>
                                    <tr>
                                        <th class="text-start fs-mona fs-mona-medium" scope="col">Product Name</th>
                                        <th class="text-end fs-mona fs-mona-medium" scope="col" width="150">Price (Rp.)</th>
                                        <th class="text-center fs-mona fs-mona-medium" scope="col" width="75">QTY</th>
                                        <th class="text-end fs-mona fs-mona-medium" scope="col" width="150">Total Price (Rp.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderDetails as $items)
                                    <tr>
                                        <td class="text-start">{{ $items->product->name }}</td>
                                        <td class="text-end">{{ number_format($items->price, 2, ',', '.') }}</td>
                                        <td class="text-center">{{ $items->qty }}</td>
                                        <td class="text-end">{{ number_format($items->total_price, 2, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="3"><strong>Total (Rp.) :</strong></td>
                                        <td class="text-end">
                                            {{ $order->total_price }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mb-4 mt-4 float-end gap-2">
                    <a href="{{ route('order.index') }}"
                        class="btn btn-link text-decoration-none text-secondary fs-mona fs-mona-semibold"> {{ __('Back') }}</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
