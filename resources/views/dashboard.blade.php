heello
<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
<form id="logout-form" action="{{ route('account.logout') }}" method="POST" style="display: none;">
    @csrf
</form>














<div class="row pb-3">
    @if($featuredProducts->isNotEmpty())
        @foreach($featuredProducts as $product)
            <div class="col-md-3">
                <div class="card product-card">
                    <div class="product-image position-relative">


                            @if($product->image != "")
                                <img class="card-img-top" src="{{asset('uploads/temp/'.$product->image)}}" alt="{{ $product->title }}">
                            @else
                                <img class="card-img-top" src="{{asset('admin/img/default-150x150.png')}}">
                            @endif


                        <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                        <div class="product-action">
                            <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }})">
                                <i class="fa fa-shopping-cart"></i> Add To Cart
                            </a>
                        </div>
                    </div>
                    <div class="card-body text-center mt-3">
                        <a class="h6 link" href="product.php">{{ $product->title }}</a>
                        <div class="price mt-2">
                            <span class="h5"><strong>{{ $product->price }}</strong></span>
                            <span class="h6 text-underline"><del>{{ $product->compare_price }}</del></span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
