<x-app-layout>
    <div class="col-12 mb-3 px-4">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h4 class="fs-mona fs-mona-medium my-0"> {{ __('List') }}</h4>
            <div class="align-self-center">
                <ul class="list-group list-group-horizontal bg-transparent border-0">
                    <li class="list-group-item bg-transparent border-0 p-0">
                        <a href="{{ route('order.create') }}" class="btn btn-success">{{ __('Add New') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card border-0 rounded-3 table-responsive">
            <div class="card-header border-0 bg-transparent">
                <div class="row row-cols-1">
                    <div class="col d-flex flex-row-reverse pe-4 pt-2">
                        <button class="btn btn-sm btn-secondary text-decoration-none fs-mona fs-mona-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-filter" aria-expanded="true" aria-controls="collapse-filter" title="filter">
                            <i class="fas fa-filter text-white"></i>
                        </button>
                    </div>
                    <div id="collapse-filter" class="col collapse show px-4 mt-2">
                        <div class="row row-cols-1">
                            <div class="col mb-2">
                                <form id="frm-filter">
                                    <div class="mb-3">
                                        <label for="search" class="form-label">{{ __('Order No / Customer / Total Items / Total Price') }}</label>
                                        <input type="text" id="inp-filter-search" class="form-control inp-filter" autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <label for="order-date" class="form-label">{{ __('Order Date') }}</label>
                                        <div class="input-group">
                                            <input type="date" id="order-date-from" class="form-control" value="{{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->subDays(7)->format('Y-m-d') }}" autocomplete="off">
                                            <span class="input-group-text bg-transparent border-0"> - </span>
                                            <input type="date" id="order-date-to" class="form-control" value="{{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d') }}" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="create-date" class="form-label">{{ __('Create Date') }}</label>
                                        <div class="input-group">
                                            <input type="datetime-local" id="create-date-from" class="form-control" value="{{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->subDays(7)->format('Y-m-d H:i') }}" autocomplete="off">
                                            <span class="input-group-text bg-transparent border-0"> - </span>
                                            <input type="datetime-local" id="create-date-to" class="form-control" value="{{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i') }}" autocomplete="off">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col text-end">
                                <button id="btn-filter-clear" class="btn btn-danger float-right ml-1"> {{
                                    __('Clear') }}</button>
                                <button type="submit" form="frm-filter" id="btn-filter-search" class="btn btn-primary float-right ml-1"> {{
                                    __('Search') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table id="tbl-list" class="table table-app">
                <thead>
                    <tr class="px-2">
                        <th class="text-center fs-mona fs-mona-semibold" scope="col" width="75" style="vertical-align: middle;">#</th>
                        <th class="text-start fs-mona fs-mona-semibold" scope="col" style="vertical-align: middle;">{{ __('Customer') }}</th>
                        <th class="text-center fs-mona fs-mona-semibold" scope="col" width="200" style="vertical-align: middle;">{{ __('Order No') }}</th>
                        <th class="text-center fs-mona fs-mona-semibold" scope="col" width="150" style="vertical-align: middle;">{{ __('Order Date') }}</th>
                        <th class="text-center fs-mona fs-mona-semibold" scope="col" width="175" style="vertical-align: middle;">{{ __('Create Date') }}</th>
                        <th class="text-center fs-mona fs-mona-semibold" scope="col" width="85" style="vertical-align: middle;">{{ __('Total Items') }}</th>
                        <th class="text-end fs-mona fs-mona-semibold" scope="col" width="150" style="vertical-align: middle;">{{ __('Total Price (Rp.)') }}</th>
                        <th class="text-center fs-mona fs-mona-semibold" scope="col" width="75" style="vertical-align: middle;"></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    @push('inline-script')
        const url = {
        "datatables": "{{ route('order.list') }}",
        }
    @endpush
</x-app-layout>
