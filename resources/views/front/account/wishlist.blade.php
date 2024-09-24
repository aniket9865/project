@extends('front.layout.app')
@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('front.accountsidebar')
                </div>
                <div class="col-md-9">
                    <div class="card">
{{--                        <div class="card-header">--}}
{{--                            <h2 class="h5 mb-0 pt-2 pb-2">My Whishlist</h2>--}}
{{--                        </div>--}}

{{--                        <div class="card-body p-4">--}}
{{--                            <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">--}}
{{--                                <div class="d-block d-sm-flex align-items-start text-center text-sm-start"><a class="d-block flex-shrink-0 mx-auto me-sm-4" href="#" style="width: 10rem;"><img src="images/product-1.jpg" alt="Product"></a>--}}
{{--                                    <div class="pt-2">--}}
{{--                                        <h3 class="product-title fs-base mb-2"><a href="shop-single-v1.html">TH Jeans City Backpack</a></h3>--}}
{{--                                        <div class="fs-lg text-accent pt-2">$79.<small>50</small></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">--}}
{{--                                    <button class="btn btn-outline-danger btn-sm" type="button"><i class="fas fa-trash-alt me-2"></i>Remove</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Wishlist</h2>
                        </div>

                        <div class="card-body p-4">
                            @forelse ($wishlists as $wishlist)
                                <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                                    <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                                        <a class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{ route("front.product", $wishlist->product->slug) }}" style="width: 10rem;">
{{--                                            <img src="{{ asset($wishlist->product->image_path) }}" alt="{{ $wishlist->product->title }}">--}}
                                            @if ($wishlist->product && $wishlist->product->image)
                                                <img class="card-img-top" width="100" height="100" src="{{ asset('uploads/temp/' . $wishlist->product->image) }}" alt="{{ $wishlist->product->title }}">
                                            @else
                                                <img class="card-img-top" src="{{ asset('admin/img/default-150x150.png') }}" width="100" height="100" alt="Default Image">
                                            @endif

                                        </a>
                                        <div class="pt-2">
                                            <h3 class="product-title fs-base mb-2">
                                                <a href="{{ route("front.product", $wishlist->product->slug) }}">{{ $wishlist->product->title }}</a>
                                            </h3>
                                            <div class="fs-lg text-accent pt-2">${{ number_format($wishlist->product->price, 2) }}</div>
                                        </div>
                                    </div>
                                    <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                        <form action="{{ route('wishlist.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $wishlist->product_id }}">
                                            <button class="btn btn-outline-danger btn-sm" type="submit">
                                                <i class="fas fa-trash-alt me-2"></i>Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center">Your wishlist is empty.</p>
                            @endforelse
                        </div>


                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
@section('customjs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle remove button click with confirmation
            $('.btn-outline-danger').on('click', function(e) {
                e.preventDefault(); // Prevent default form submission

                let confirmation = confirm('Are you sure you want to remove this item from your wishlist?');
                if (!confirmation) {
                    return; // Exit if user cancels
                }

                let form = $(this).closest('form'); // Get the form element
                let formData = form.serialize(); // Serialize form data

                $.ajax({
                    url: form.attr('action'), // Use the form's action attribute as the URL
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // On success, remove the wishlist item from the DOM
                        form.closest('.d-sm-flex').remove();

                        // Optionally, show a message or update the wishlist count
                        if ($('.d-sm-flex').length === 0) {
                            $('.card-body').html('<p class="text-center">Your wishlist is empty.</p>');
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while removing the item. Please try again.');
                    }
                });
            });
        });
    </script>

@endsection

