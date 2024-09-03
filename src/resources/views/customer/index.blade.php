<x-app-layout>
    <div class="col-12 mb-3 px-4">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h4 class="fs-mona fs-mona-medium my-0"> {{ __('List') }}</h4>
            <div class="align-self-center">
                <ul class="list-group list-group-horizontal bg-transparent border-0">
                    <li class="list-group-item bg-transparent border-0 p-0">
                        <a href="{{ route('customer.create') }}" class="btn btn-success">{{ __('Add New') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card border-0 rounded-3">
            <table id="tbl-list" class="table table-app">
                <thead>
                    <tr class="px-2">
                        <th class="text-center fs-mona fs-mona-semibold" scope="col" width="75">#</th>
                        <th class="text-start fs-mona fs-mona-semibold" scope="col">{{ __('Name') }}</th>
                        <th class="text-center fs-mona fs-mona-semibold" scope="col" width="85"></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @push('inline-script')
        const url = {
            "datatables": "{{ route('customer.list') }}",
        }
    @endpush
</x-app-layout>
