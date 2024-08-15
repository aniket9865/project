@extends('front.layout.app')
@section('content')
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                        <li class="breadcrumb-item">Cart</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-9 pt-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table" id="cart">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($cartContent))
                                    @foreach($cartContent as $item)
                                        <tr data-rowid="{{ $item->rowId }}">
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    @if(!empty($item->options->image))
                                                        <img class="card-img-top" src="{{ asset('uploads/temp/' . $item->options->image) }}" alt="{{ $item->name }}" width="100" height="100">
                                                    @else
                                                        <img class="card-img-top" src="{{ asset('admin/img/default-150x150.png') }}" width="100" height="100">
                                                    @endif
                                                    <h2>{{ $item->name }}</h2>
                                                </div>
                                            </td>
                                            <td>{{ $item->price }}</td>
                                            <td>
                                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                                    <form action="{{route('cart.index')}}" method="get">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    </form>
                                                    <input type="text" class="form-control form-control-sm border-0 text-center qty" value="{{ $item->qty }}">
                                                    <div class="input-group-btn">
                                                        <form action="{{route('cart.index')}}" method="get">
                                                        <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $item->price * $item->qty }}</td>
                                            <td>
                                                <form action="{{route('cart.index')}}" method="get">
                                                <button class="btn btn-sm btn-danger btn-remove">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="card cart-summery">
                            <div class="sub-title">
                                <h2 class="bg-white">Cart Summery</h2>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between pb-2">
                                    <div>Subtotal</div>
                                    <div>${{ Cart::subtotal() }}</div>
                                 </div>
                                <div class="d-flex justify-content-between pb-2">
                                    <div>Shipping</div>
                                    <div>0</div>
                                </div>
                                <div class="d-flex justify-content-between summery-end">
                                    <div>Total</div>
                                    <div>${{ Cart::subtotal() }}</div>
                                </div>
                            </div>
                            <div class="pt-5">
                                <a href="{{route('account.login')}}" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                            </div>
{{--                        <div class="input-group apply-coupan mt-4">--}}
{{--                            <input type="text" placeholder="Coupon Code" class="form-control">--}}
{{--                            <button class="btn btn-dark" type="button" id="button-addon2">Apply Coupon</button>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('customjs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Update quantity
            $('#cart').on('click', '.btn-plus, .btn-minus', function() {
                var row = $(this).closest('tr');
                var rowId = row.data('rowid');
                var qtyInput = row.find('.qty');
                var currentQty = parseInt(qtyInput.val());
                var newQty = $(this).hasClass('btn-plus') ? currentQty + 1 : Math.max(currentQty - 1, 1);

                qtyInput.val(newQty);

                $.ajax({
                    url: '{{ route('cart.update') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        rowId: rowId,
                        qty: newQty
                    },
                    success: function(response) {
                        if (response.status) {
                            // Reload the page after updating the cart
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });

            // Remove item
            $('#cart').on('click', '.btn-remove', function() {
                var row = $(this).closest('tr');
                var rowId = row.data('rowid');

                $.ajax({
                    url: '{{ route('cart.remove') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        rowId: rowId
                    },
                    success: function(response) {
                        if (response.status) {
                            // Reload the page after removing the item
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>
@endsection

