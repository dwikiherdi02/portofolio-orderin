<div class="col-12 col-sm-3 col-md-4 mb-3">
    <div class="card">
        <div class="card-header" style="height: 150px;">
            <img src="{{ $product->image }}" alt="product-image" style="height: 100%; width: auto; display: block; margin-left: auto; margin-right: auto;">
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">
                {{ $product->description}}
            </p>
            <p class="card-text text-end">
                {{ $product->price }}
            </p>
            <button class="btn btn-success btn-add-cart w-100" data-id="{{ $product->id }}" data-content='{!! json_encode($product->toArray()) !!}'>
                Add
            </button>
        </div>
    </div>
</div>
