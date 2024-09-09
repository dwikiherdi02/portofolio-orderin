<x-app-layout>
    <div class="col-12 col-lg-8 pb-3" style="height: 80vh;">
        <div class="card h-100">
            <div class="card-header bg-transparent">
                <div class="input-group">
                    <input type="text" id="frm-search" class="form-control" placeholder="Search Product" aria-label="Search Product" aria-describedby="btn-search">
                    <button class="btn btn-outline-default border border-0" type="submit" id="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
            <div class="card-body overflow-y-auto">
                <div id="items-content" class="row row-cols-3" style="display: none;">
                    <div class="col-12 col-sm-4 col-md-3">
                        <div class="card">
                            <img src="..." class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example</p>
                                <button type="button" class="btn btn-success w-100">Add</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="items-content-placeholder" class="row row-cols-3">
                    @for ($i=0; $i < 3; $i++)
                        <div class="col-12 col-sm-3 col-md-4 mb-3">
                            <div class="card" aria-hidden="true">
                                <div class="card-header bg-secondary" style="height: 150px;"></div>
                                <div class="card-body">
                                    <h5 class="card-title placeholder-glow"><span class="placeholder col-6"></span></h5>
                                    <p class="card-text placeholder-glow">
                                        <span class="placeholder col-7"></span>
                                        <span class="placeholder col-4"></span>
                                    </p>
                                    <button class="btn btn-success disabled placeholder w-100" aria-disabled="true"></button>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4 pb-3" style="height: 80vh;">
        <div class="card h-100">
            <div class="card-header bg-transparent">
                <h3 class="mb-1">Cart List</h3>
            </div>
            <div class="card-body overflow-y-auto">
                <div class="row row-cols-1">
                    <div class="col-12">
                        <div class="card" style="height: 70px">
                            <div class="card-body d-flex flex-row h-100">
                                <div class="img-content" style="width: 20%"></div>
                                <div class="text-content" style="width: 80%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">

            </div>
        </div>
    </div>
    @push('inline-script')
        const url = {
            "productlist": "{{ route('product.ajax.list') }}",
        };
    @endpush
</x-app-layout>
