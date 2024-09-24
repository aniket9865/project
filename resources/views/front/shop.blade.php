
@extends('front.layout.app')

@section('content')
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a class="white-text" href="{{ route('front.shop') }}">Shop</a></li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-6 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 sidebar">
                        <div class="sub-title">
                            <h2>Categories</h2>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-flush" id="accordionExample">
                                    @if($categories->isNotEmpty())
                                        @foreach($categories as $key => $category)
                                            <div class="accordion-item">
                                                @if($category->sub_category->isNotEmpty())
                                                    <h2 class="accordion-header" id="heading-{{ $key }}">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapse-{{ $key }}">
                                                            {{ $category->name }}
                                                        </button>
                                                    </h2>
                                                @else
                                                    <a href="{{ route('front.shop', $category->slug) }}" class="nav-item nav-link{{ ($categorySelected == $category->id) ? ' text-primary' : '' }}">{{ $category->name }}</a>
                                                @endif

                                                @if($category->sub_category->isNotEmpty())
                                                    <div id="collapse-{{ $key }}" class="accordion-collapse collapse{{ ($categorySelected == $category->id) ? ' show' : '' }}" aria-labelledby="heading-{{ $key }}" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="navbar-nav">
                                                                @foreach($category->sub_category as $sub_category)
                                                                    <a href="{{ route('front.shop', [$category->slug, $sub_category->slug]) }}" class="nav-item nav-link{{ ($subCategorySelected == $sub_category->id) ? ' text-primary' : '' }}">{{ $sub_category->name }}</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="sub-title mt-5">
                            <h2>Brand</h2>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                @if($brands->isNotEmpty())
                                    @foreach($brands as $brand)
                                        <div class="form-check mb-2">
                                            <input {{ in_array($brand->id, $brandsArray) ? 'checked' : '' }} class="form-check-input brand-label" name="brand[]" type="checkbox" value="{{ $brand->id }}" id="brand-{{ $brand->id }}">
                                            <label class="form-check-label" for="brand-{{ $brand->id }}">
                                                {{ $brand->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

{{--                        <div class="sub-title mt-5">--}}
{{--                            <h2>Price</h2>--}}
{{--                        </div>--}}

{{--                        <div class="card">--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="form-check mb-2">--}}
{{--                                    <input class="form-check-input" type="checkbox" value="0-100" id="price-0-100">--}}
{{--                                    <label class="form-check-label" for="price-0-100">--}}
{{--                                        $0-$100--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check mb-2">--}}
{{--                                    <input class="form-check-input" type="checkbox" value="100-200" id="price-100-200">--}}
{{--                                    <label class="form-check-label" for="price-100-200">--}}
{{--                                        $100-$200--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check mb-2">--}}
{{--                                    <input class="form-check-input" type="checkbox" value="200-500" id="price-200-500">--}}
{{--                                    <label class="form-check-label" for="price-200-500">--}}
{{--                                        $200-$500--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check mb-2">--}}
{{--                                    <input class="form-check-input" type="checkbox" value="500+" id="price-500-plus">--}}
{{--                                    <label class="form-check-label" for="price-500-plus">--}}
{{--                                        $500+--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>

                    <div class="col-md-9">
                        <div class="row pb-3">
                            <div class="col-12 pb-1">
                                <div class="d-flex align-items-center justify-content-end mb-4">
                                    <div class="ml-2">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">Sorting</button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#">Latest</a>
                                                <a class="dropdown-item" href="#">Price High</a>
                                                <a class="dropdown-item" href="#">Price Low</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($products->isNotEmpty())
                                @foreach($products as $product)
                                    <div class="col-md-4">
                                        <div class="card product-card">
                                            <div class="product-image position-relative">
                                                <a href="{{route("front.product", $product->slug)}}"  class="product-img">
                                                    @if(!empty($product->image))
                                                        <img class="card-img-top" src="{{ asset('uploads/temp/' . $product->image) }}" alt="{{ $product->title }}">
                                                    @else
                                                        <img class="card-img-top" src="{{asset('admin/img/default-150x150.png')}}">
                                                    @endif
                                                </a>
                                                <a class="wishlist" href="#" data-product-id="{{ $product->id }}"><i class="far fa-heart"></i></a>
{{--                                                <div class="product-action">--}}
{{--                                                    <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }})" data-product-id="{{ $product->id }}">--}}
{{--                                                        <i class="fa fa-shopping-cart"></i> Add To Cart--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
                                                <div class="product-action">
                                                    @if(trim(strtolower($product->track_qty)) == 'yes')
                                                        @if ($product->qty > 0)
                                                            <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }})" data-product-id="{{ $product->id }}">
                                                                <i class="fa fa-shopping-cart"></i> Add To Cart
                                                            </a>
                                                        @else
                                                            <a class="btn btn-dark" href="javascript:void(0);">
                                                                Out Of Stock
                                                            </a>
                                                        @endif
                                                    @else
                                                        <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }})" data-product-id="{{ $product->id }}">
                                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                                        </a>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="card-body text-center mt-3">
                                                <a class="h6 link" href="#" data-product-id="{{ $product->id }}">{{ $product->title }}</a>
                                                <div class="price mt-2">
                                                    <span class="h5"><strong>${{ number_format($product->price, 2) }}</strong></span>
                                                    @if($product->compare_price > 0)
                                                        <span class="h6 text-underline"><del>${{ number_format($product->compare_price, 2) }}</del></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <div class="col-md-12 pt-5">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        {{ $products->links('pagination::bootstrap-4') }}
                                    </ul>
                                </nav>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('customjs')
    <script>
        $(".brand-label").change(function() {
            applyFilters();
        });

        function applyFilters() {
            var brands = [];

            $(".brand-label").each(function() {
                if ($(this).is(":checked")) {
                    brands.push($(this).val());
                }
            });

            var url = '{{ url()->current() }}';

            // Append the brand filters to the URL
            if (brands.length > 0) {
                url += (url.indexOf('?') === -1 ? '?' : '&') + 'brand=' + encodeURIComponent(brands.join(','));
            } else {
                // Remove the brand parameter if no brand is selected
                url = url.split('?')[0];
            }

            window.location.href = url;
        }
    </script>
@endsection
