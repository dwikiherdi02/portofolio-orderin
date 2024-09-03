<x-app-layout>
    <div class="card border-0">
        <div class="card-body">
            <div class="col-12 col-lg-8">
                <x-form :method="__('PUT')" action="{{ route('customer.update', ['customer' => $customer->id ]) }}" id="form-edit" data-submit-button="#btn-edit" data-callback="">
                    <div class="mb-4">
                        <label for="name" class="form-label fs-mona fs-mona-medium">
                            {{ __('Name') }} <span class=text-danger>*</span>
                        </label>
                        <input type="text" id="name" class="form-control" name="name" value="{{ $customer->name }}" autocomplete="off">
                        <x-input-error :forname="__('name')"></x-input-error>
                    </div>
                    <div class="mb-4">
                        <label for="address" class="form-label fs-mona fs-mona-medium">{{ __('Address') }}</label>
                        <textarea name="address" id="address" class="form-control" rows="5">{{ $customer->address }}</textarea>
                    </div>
                    <div class="mb-4 mt-4 float-end gap-2">
                        <a href="{{ route('customer.index') }}"
                            class="btn btn-link text-decoration-none text-secondary fs-mona fs-mona-semibold"> {{ __('Back') }}</a>

                        <button type="submit" id="btn-edit" class="btn btn-success">
                            {{ __('Save') }}
                        </button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- <x-app-layout>
    <div class="card">
        <div class="col-12 col-lg-8">
            <div class="card-body">
                <x-form :method="__('PUT')" action="{{ route('customer.update', ['customer' => $customer->id ]) }}" id="form-edit"
                    data-submit-button="#btn-edit" data-callback="">
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            {{ __('Name') }} <span class=text-danger>*</span>
                        </label>
                        <input type="text" id="name" class="form-control" name="name" value="{{ $customer->name }}" autocomplete="off">
                        <x-input-error :forname="__('name')"></x-input-error>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">{{ __('Address') }}</label>
                        <textarea name="address" id="address" class="form-control" rows="3">{{ $customer->address }}</textarea>
                    </div>
                    <div class="mb-3 float-end gap-2">
                        <a href="{{ route('customer.index') }}" class="btn btn-secondary"> {{ __('Back') }}</a>

                        <button type="submit" id="btn-edit" class="btn btn-primary">
                            {{ __('Save') }}
                        </button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</x-app-layout> --}}
