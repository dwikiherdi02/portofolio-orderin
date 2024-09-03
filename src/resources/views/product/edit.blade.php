<x-app-layout>
    <div class="card border-0">
        <div class="col-12 col-lg-8">
            <div class="card-body">
                <x-form :method="__('PUT')" action="{{ route('product.update', ['product' => $product->id]) }}" id="form-edit"
                    enctype="multipart/form-data" data-submit-button="#btn-edit" data-callback="">
                    <div class="mb-3">
                        <x-upload-image :size="__('md')" :name="__('image')" :isactive="$product->image ? true : false">
                            <x-slot:image>
                                <img src="{{ $product->image }}" alt="image">
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
                        <input type="text" id="name" class="form-control" name="name" value="{{ $product->name }}" autocomplete="off">
                        <x-input-error :forname="__('name')"></x-input-error>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label fs-mona fs-mona-medium">{{ __('Price') }} <span class=text-danger>*</span>
                        </label></label>
                        <input type="number" id="price" class="form-control text-end" name="price" value="{{ number_format($product->price, 0, '', '') }}">
                        <x-input-error :forname="__('price')"></x-input-error>
                    </div>
                    <div class="mb-3">
                        <label for="categories" class="form-label fs-mona fs-mona-medium">{{ __('Categories') }}</label>
                        <select name="categories[]" id="categories" class="form-control" multiple="multiple">
                            @php
                                $selectedCategories = array_flip($product->categories);
                            @endphp
                            @foreach ($categories as $category)
                            @php
                                $name = ucwords($category->name);
                                $selected = isset($selectedCategories[$name]) ? 'selected' : '';
                            @endphp
                            <option {{ $selected }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fs-mona fs-mona-medium">{{ __('Description') }}</label>
                        <textarea name="description" id="description" class="form-control" rows="3">{{ $product->description }}</textarea>
                    </div>
                    <div class="mb-4 mt-4 float-end gap-2">
                        <a href="{{ route('product.index') }}" class="btn fs-mona fs-mona-semibold"> {{ __('Back') }}</a>

                        <button type="submit" id="btn-edit" class="btn btn-success">
                            {{ __('Save') }}
                        </button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</x-app-layout>
