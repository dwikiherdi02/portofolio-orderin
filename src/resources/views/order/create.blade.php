<x-app-layout>
    <div class="card border-0">
        <div class="card-body">
            <div class="col-12 col-lg-8">
                <x-form :method="__('POST')" action="{{ route('order.store') }}" id="form-add" data-submit-button="#btn-add" data-callback="">
                    <div class="mb-3">
                        <label for="order-date" class="form-label fs-mona fs-mona-medium">
                            {{ __('Order Date') }} <span class=text-danger>*</span>
                        </label>
                        <input type="date" id="order-date" class="form-control" name="ordered_at" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" autocomplete="off">
                        <x-input-error :forname="__('ordered_at')"></x-input-error>
                    </div>
                    <div class="mb-3">
                        <label for="customer" class="form-label fs-mona fs-mona-medium">
                            {{ __('Customer') }} <span class=text-danger>*</span>
                        </label>
                        <select name="customer_id" class="form-select" aria-label="Default select example">
                            <option selected disabled>Select Customer</option>
                            @foreach ($customers as $item)
                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                            @endforeach
                        </select>
                        <x-input-error :forname="__('customer_id')"></x-input-error>
                    </div>
                    <div class="mb-3">
                        <a href="javascript:;" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#mdl-list-products">{{ __('Add Products') }}</a>
                        <x-input-error :forname="__('detail')"></x-input-error>
                        <div class="my-3">
                            <div class="card">
                                <div class="card-header bg-transparent d-flex flex-column flex-md-row justify-content-md-between align-items-center">
                                    <div>
                                        <strong class="fs-5">Total (Rp.): <span id="ttl-ordered-product"></span></strong>
                                    </div>
                                    <h6 class="m-0 my-2 fs-mona fs-mona-medium">{{ __('Ordered Products') }}</h6>
                                </div>
                                <div class="card-body pt-3 table-responsive">
                                    <table id="tbl-ordered-product" class="table table-app">
                                        <thead>
                                            <tr>
                                                {{-- <th class="text-center fs-mona fs-mona-medium" scope="col" width="75">#</th> --}}
                                                <th class="text-start fs-mona fs-mona-medium" scope="col">Product Name</th>
                                                <th class="text-end fs-mona fs-mona-medium" scope="col" width="150">Price</th>
                                                <th class="text-center fs-mona fs-mona-medium" scope="col" width="120"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- <tr>
                                                <td class="text-start align-self-center" style="vertical-align: middle;">ABC</td>
                                                <td class="text-end align-self-center" style="vertical-align: middle;">1.000</td>
                                                <td class="text-center" style="vertical-align: middle;">
                                                    <div class="input-group input-group-sm">
                                                        <button type="button" class="btn btn-dark"><i class="fa-solid fa-minus"></i></button>
                                                        <input type="number" class="form-control text-center" min="0" value="0" aria-label="counter-qty" aria-describedby="counter-qty" readonly>
                                                        <button type="button" class="btn btn-dark"><i class="fa-solid fa-plus"></i></button>
                                                    </div>
                                                </td>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 mt-4 float-end gap-2">
                        <a href="{{ route('order.index') }}"
                            class="btn btn-link text-decoration-none text-secondary fs-mona fs-mona-semibold"> {{ __('Back') }}</a>

                        <button type="submit" id="btn-add" class="btn btn-success">
                            {{ __('Save') }}
                        </button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mdl-list-products" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mdl-list-products-label" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fs-5" id="mdl-list-products-label">{{ __('Product List') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="card border-0">
                        <table id="tbl-add-product" class="table table-app">
                            <thead>
                                <tr class="px-2">
                                    <th class="text-center fs-mona fs-mona-semibold" scope="col" width="75">#</th>
                                    <th class="text-start fs-mona fs-mona-semibold" scope="col">{{ __('Name') }}</th>
                                    <th class="text-end fs-mona fs-mona-semibold" scope="col" width="150">{{ __('Price (Rp.)') }}</th>
                                    <th class="text-center fs-mona fs-mona-semibold" scope="col" width="85"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('inline-script')
        const url = {
            "datatables": {
                "list_ordering": "{{ route('product.list_ordering') }}",
            }
        }
    @endpush
</x-app-layout>
