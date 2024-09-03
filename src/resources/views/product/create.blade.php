<x-app-layout>
    <div class="card border-0">
        <div class="col-12 col-lg-8">
            <div class="card-body">
                <x-form :method="__('POST')" action="{{ route('product.store') }}" id="form-add"
                    enctype="multipart/form-data" data-submit-button="#btn-add" data-callback="">
                    <div class="mb-3">
                        <x-upload-image :size="__('md')" :name="__('image')">
                            <x-slot:image>
                                <img src="" alt="image">
                            </x-slot:image>
                            <x-slot:uploadbtn>
                                {{ __('Upload Image') }}
                            </x-slot:uploadbtn>
                        </x-upload-image>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label fs-mona fs-mona-medium">
                            {{ __('Name') }} <span class=text-danger>*</span>
                        </label>
                        <input type="text" id="name" class="form-control" name="name" value="" autocomplete="off">
                        <x-input-error :forname="__('name')"></x-input-error>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label fs-mona fs-mona-medium">{{ __('Price') }} <span class=text-danger>*</span>
                        </label></label>
                        <input type="number" id="price" class="form-control text-end" name="price" value="">
                        <x-input-error :forname="__('price')"></x-input-error>
                    </div>
                    <div class="mb-3">
                        <label for="categories" class="form-label fs-mona fs-mona-medium">{{ __('Categories') }}</label>
                        <select name="categories[]" id="categories" class="form-control" multiple="multiple">
                            @foreach ($categories as $category)
                                <option>{{ ucwords($category->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fs-mona fs-mona-medium">{{ __('Description') }}</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-4 mt-4 float-end gap-2">
                        <a href="{{ route('product.index') }}" class="btn btn-link text-decoration-none text-secondary fs-mona fs-mona-semibold"> {{ __('Back') }}</a>

                        <button type="submit" id="btn-add" class="btn btn-success">
                            {{ __('Save') }}
                        </button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</x-app-layout>
