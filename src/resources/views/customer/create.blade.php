<x-app-layout>
    <div class="card border-0">
        <div class="card-body">
            <div class="col-12 col-lg-8">
                <x-form :method="__('POST')" action="{{ route('customer.store') }}" id="form-add" data-submit-button="#btn-add" data-callback="">
                    <div class="mb-4">
                        <label for="name" class="form-label fs-mona fs-mona-medium">
                            {{ __('Name') }} <span class=text-danger>*</span>
                        </label>
                        <input type="text" id="name" class="form-control" name="name" value="" autocomplete="off">
                        <x-input-error :forname="__('name')"></x-input-error>
                    </div>
                    <div class="mb-4">
                        <label for="address" class="form-label fs-mona fs-mona-medium">{{ __('Address') }}</label>
                        <textarea name="address"  id="address" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="mb-4 mt-4 float-end gap-2">
                        <a href="{{ route('customer.index') }}" class="btn btn-link text-decoration-none text-secondary fs-mona fs-mona-semibold"> {{ __('Back') }}</a>

                        <button type="submit" id="btn-add" class="btn btn-success">
                            {{ __('Save') }}
                        </button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</x-app-layout>
