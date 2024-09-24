{{--@extends('admin.layout.app')--}}

{{--@section('content')--}}
{{--    <!-- Content Header (Page header) -->--}}
{{--    <div id="success-message" class="alert alert-success d-none" role="alert">--}}
{{--        Update successful!--}}
{{--    </div>--}}
{{--    <section class="content-header">--}}
{{--        <div class="container-fluid my-2">--}}
{{--            <div class="row mb-2">--}}
{{--                <div class="col-sm-6">--}}
{{--                    <h1>Order: #{{ $order->id }}</h1>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6 text-right">--}}
{{--                    <a href="{{ route('orders.index') }}" class="btn btn-primary">Back</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- /.container-fluid -->--}}
{{--    </section>--}}
{{--    <!-- Main content -->--}}
{{--    <section class="content">--}}
{{--        <!-- Default box -->--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-9">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-header pt-3">--}}
{{--                            <div class="row invoice-info">--}}
{{--                                <div class="col-sm-4 invoice-col">--}}
{{--                                    <h1 class="h5 mb-3">Shipping Address</h1>--}}
{{--                                    <address>--}}
{{--                                        <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>--}}
{{--                                        {{ $order->address }}<br>--}}
{{--                                        {{ $order->city }}, {{ $order->zip }}, {{ $order->countryName }}<br>--}}
{{--                                        Phone: {{ $order->mobile }}<br>--}}
{{--                                        Email: {{ $order->email }}--}}
{{--                                    </address>--}}
{{--                                    <strong>Shipped Date:</strong>--}}
{{--                                    @if (empty($order->shipped_date))--}}
{{--                                        n/a--}}
{{--                                    @else--}}
{{--                                        {{ \Carbon\Carbon::parse($order->shipped_date)->format('d M, Y') }}--}}
{{--                                    @endif--}}
{{--                                </div>--}}

{{--                                <div class="col-sm-4 invoice-col">--}}
{{--                                    <b>Invoice </b><br><br>--}}
{{--                                    <b>Order ID:</b> {{ $order->id }}<br>--}}
{{--                                    <b>Total:</b> {{ number_format($order->grand_total, 2) }}<br>--}}
{{--                                    <b>Status:</b>--}}
{{--                                    @if ($order->status == 'pending')--}}
{{--                                        <span class="text-danger">Pending</span>--}}
{{--                                    @elseif ($order->status == 'shipped')--}}
{{--                                        <span class="text-info">Shipped</span>--}}
{{--                                    @elseif ($order->status == 'delivered')--}}
{{--                                        <span class="text-success">Delivered</span>--}}
{{--                                    @elseif($order->status == 'cancelled')--}}
{{--                                        <span class="text-danger">Cancelled</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="card-body table-responsive p-3">--}}
{{--                            <table class="table table-striped">--}}
{{--                                <thead>--}}
{{--                                <tr>--}}
{{--                                    <th>Product</th>--}}
{{--                                    <th width="100">Price</th>--}}
{{--                                    <th width="100">Qty</th>--}}
{{--                                    <th width="100">Total</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @foreach ($orderItems as $item)--}}
{{--                                    <tr>--}}
{{--                                        <td>{{ $item->name }}</td>--}}
{{--                                        <td>${{ number_format($item->price, 2) }}</td>--}}
{{--                                        <td>{{ $item->qty }}</td>--}}
{{--                                        <td>${{ number_format($item->total, 2) }}</td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}

{{--                                <tr>--}}
{{--                                    <th colspan="3" class="text-right">Subtotal:</th>--}}
{{--                                    <td>${{ number_format($order->subtotal, 2) }}</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th colspan="3" class="text-right">Discount:</th>--}}
{{--                                    <td>${{ number_format($order->discount, 2) }}</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th colspan="3" class="text-right">Shipping:</th>--}}
{{--                                    <td>${{ number_format($order->shipping, 2) }}</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th colspan="3" class="text-right">Grand Total:</th>--}}
{{--                                    <td>${{ number_format($order->grand_total, 2) }}</td>--}}
{{--                                </tr>--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-3">--}}
{{--                    <div class="card">--}}
{{--                        <form action="{{ route('orders.changeOrderStatus', $order->id) }}" method="post" name="changeOrderStatusForm" id="changeOrderStatusForm">--}}
{{--                            @csrf--}}
{{--                            <div class="card-body">--}}
{{--                                <h2 class="h4 mb-3">Order Status</h2>--}}
{{--                                <div class="mb-3">--}}
{{--                                    <select name="status" id="status" class="form-control">--}}
{{--                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>--}}
{{--                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>--}}
{{--                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>--}}
{{--                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label for="shipped_date">Shipped Date</label>--}}
{{--                                    <input value="{{ $order->shipped_date }}" type="datetime-local" name="shipped_date" id="shipped_date" class="form-control">--}}
{{--                                </div>--}}
{{--                                <div class="mb-3">--}}
{{--                                    <button class="btn btn-primary">Update</button>--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-body">--}}
{{--                            <h2 class="h4 mb-3">Send Invoice Email</h2>--}}
{{--                            <div class="mb-3">--}}
{{--                                <select name="status" id="status" class="form-control">--}}
{{--                                    <option value="">Customer</option>--}}
{{--                                    <option value="">Admin</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="mb-3">--}}
{{--                                <button class="btn btn-primary">Send</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- /.card -->--}}
{{--    </section>--}}
{{--@endsection--}}

{{--@section('customjs')--}}
{{--    <!-- Include necessary libraries for Bootstrap DateTime Picker -->--}}
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datetimepicker@4.17.47/build/css/bootstrap-datetimepicker.min.css">--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datetimepicker@4.17.47/build/js/bootstrap-datetimepicker.min.js"></script>--}}

{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('#shipped_date').datetimepicker({--}}
{{--                format: 'Y-m-d H:i:s',  // Format for the datetime picker--}}
{{--            });--}}
{{--        });--}}

{{--        $("#changeOrderStatusForm").submit(function(event) {--}}
{{--            event.preventDefault();--}}

{{--            $.ajax({--}}
{{--                url: $(this).attr('action'),--}}
{{--                type: 'POST',--}}
{{--                data: $(this).serialize(),--}}
{{--                dataType: 'json',--}}
{{--                headers: {--}}
{{--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Add CSRF token--}}
{{--                },--}}
{{--                success: function(response) {--}}
{{--                    $('#success-message').removeClass('d-none');--}}
{{--                    setTimeout(function() {--}}
{{--                        $('#success-message').addClass('d-none');--}}
{{--                    }, 3000);--}}
{{--                    window.location.href = "{{ route('orders.detail', $order->id) }}";--}}
{{--                },--}}
{{--                error: function(xhr, status, error) {--}}
{{--                    console.log(xhr.responseText);--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}



{{--@extends('admin.layout.app')--}}

{{--@section('content')--}}
{{--    <!-- Success Message -->--}}
{{--    <div id="success-message" class="alert alert-success d-none" role="alert">--}}
{{--        Update successful!--}}
{{--    </div>--}}

{{--    <!-- Content Header -->--}}
{{--    <section class="content-header">--}}
{{--        <div class="container-fluid my-2">--}}
{{--            <div class="row mb-2">--}}
{{--                <div class="col-sm-6">--}}
{{--                    <h1>Order: #{{ $order->id }}</h1>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6 text-right">--}}
{{--                    <a href="{{ route('orders.index') }}" class="btn btn-primary">Back</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

{{--    <!-- Main content -->--}}
{{--    <section class="content">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-9">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-header pt-3">--}}
{{--                            <div class="row invoice-info">--}}
{{--                                <div class="col-sm-4 invoice-col">--}}
{{--                                    <h1 class="h5 mb-3">Shipping Address</h1>--}}
{{--                                    <address>--}}
{{--                                        <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>--}}
{{--                                        {{ $order->address }}<br>--}}
{{--                                        {{ $order->city }}, {{ $order->zip }}, {{ $order->countryName }}<br>--}}
{{--                                        Phone: {{ $order->mobile }}<br>--}}
{{--                                        Email: {{ $order->email }}--}}
{{--                                    </address>--}}
{{--                                    <strong>Shipped Date:</strong>--}}
{{--                                    {{ $order->shipped_date ? \Carbon\Carbon::parse($order->shipped_date)->format('d M, Y') : 'n/a' }}--}}
{{--                                </div>--}}

{{--                                <div class="col-sm-4 invoice-col">--}}
{{--                                    <b>Invoice </b><br><br>--}}
{{--                                    <b>Order ID:</b> {{ $order->id }}<br>--}}
{{--                                    <b>Total:</b> {{ number_format($order->grand_total, 2) }}<br>--}}
{{--                                    <b>Status:</b>--}}
{{--                                    <span class="{{ $order->status === 'pending' ? 'text-danger' : ($order->status === 'shipped' ? 'text-info' : ($order->status === 'delivered' ? 'text-success' : 'text-danger')) }}">--}}
{{--                                        {{ ucfirst($order->status) }}--}}
{{--                                    </span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="card-body table-responsive p-3">--}}
{{--                            <table class="table table-striped">--}}
{{--                                <thead>--}}
{{--                                <tr>--}}
{{--                                    <th>Product</th>--}}
{{--                                    <th width="100">Price</th>--}}
{{--                                    <th width="100">Qty</th>--}}
{{--                                    <th width="100">Total</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @foreach ($orderItems as $item)--}}
{{--                                    <tr>--}}
{{--                                        <td>{{ $item->name }}</td>--}}
{{--                                        <td>${{ number_format($item->price, 2) }}</td>--}}
{{--                                        <td>{{ $item->qty }}</td>--}}
{{--                                        <td>${{ number_format($item->total, 2) }}</td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                                <tr>--}}
{{--                                    <th colspan="3" class="text-right">Subtotal:</th>--}}
{{--                                    <td>${{ number_format($order->subtotal, 2) }}</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th colspan="3" class="text-right">Discount:</th>--}}
{{--                                    <td>${{ number_format($order->discount, 2) }}</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th colspan="3" class="text-right">Shipping:</th>--}}
{{--                                    <td>${{ number_format($order->shipping, 2) }}</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th colspan="3" class="text-right">Grand Total:</th>--}}
{{--                                    <td>${{ number_format($order->grand_total, 2) }}</td>--}}
{{--                                </tr>--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-3">--}}
{{--                    <div class="card">--}}
{{--                        <form action="{{ route('orders.changeOrderStatus', $order->id) }}" method="post" id="changeOrderStatusForm">--}}
{{--                            @csrf--}}
{{--                            <div class="card-body">--}}
{{--                                <h2 class="h4 mb-3">Order Status</h2>--}}
{{--                                <div class="mb-3">--}}
{{--                                    <select name="status" id="status" class="form-control">--}}
{{--                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>--}}
{{--                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>--}}
{{--                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>--}}
{{--                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label for="shipped_date">Shipped Date</label>--}}
{{--                                    <input value="{{ $order->shipped_date }}" type="datetime-local" name="shipped_date" id="shipped_date" class="form-control">--}}
{{--                                </div>--}}
{{--                                <div class="mb-3">--}}
{{--                                    <button class="btn btn-primary">Update</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

{{--    <!-- Success Modal -->--}}
{{--    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">--}}
{{--        <div class="modal-dialog" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="successModalLabel">Success</h5>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    Order status updated successfully!--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                    <button type="button" class="btn btn-primary" id="modalOkButton">OK</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

{{--@section('customjs')--}}
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datetimepicker@4.17.47/build/css/bootstrap-datetimepicker.min.css">--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datetimepicker@4.17.47/build/js/bootstrap-datetimepicker.min.js"></script>--}}

{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            var today = new Date();--}}
{{--            var year = today.getFullYear();--}}
{{--            var month = String(today.getMonth() + 1).padStart(2, '0');--}}
{{--            var day = String(today.getDate()).padStart(2, '0');--}}
{{--            var formattedToday = year + '-' + month + '-' + day + 'T00:00';--}}

{{--            $('#shipped_date').attr('min', formattedToday);--}}
{{--            $('#shipped_date').datetimepicker({--}}
{{--                format: 'Y-m-d H:i:s',--}}
{{--            });--}}

{{--            $("#changeOrderStatusForm").submit(function(event) {--}}
{{--                event.preventDefault();--}}

{{--                $.ajax({--}}
{{--                    url: $(this).attr('action'),--}}
{{--                    type: 'POST',--}}
{{--                    data: $(this).serialize(),--}}
{{--                    dataType: 'json',--}}
{{--                    headers: {--}}
{{--                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                    },--}}
{{--                    success: function(response) {--}}
{{--                        console.log(response); // Debugging--}}
{{--                        if (response.status) {--}}
{{--                            $('#successModal').modal('show');--}}
{{--                            $('#modalOkButton').off('click').on('click', function() {--}}
{{--                                window.location.href = "{{ route('orders.index') }}"; // Redirect here--}}
{{--                            });--}}
{{--                        } else {--}}
{{--                            alert(response.message);--}}
{{--                        }--}}
{{--                    },--}}
{{--                    error: function(xhr, status, error) {--}}
{{--                        console.log(xhr.responseText);--}}
{{--                        alert('An error occurred while updating the order status.');--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}


@extends('admin.layout.app')

@section('content')
    <!-- Success Message -->
    <div id="success-message" class="alert alert-success d-none" role="alert">
        Update successful!
    </div>

    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order: #{{ $order->id }}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('orders.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header pt-3">
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <h1 class="h5 mb-3">Shipping Address</h1>
                                    <address>
                                        <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                                        {{ $order->address }}<br>
                                        {{ $order->city }}, {{ $order->zip }}, {{ $order->countryName }}<br>
                                        Phone: {{ $order->mobile }}<br>
                                        Email: {{ $order->email }}
                                    </address>
                                    <strong>Shipped Date:</strong>
                                    {{ $order->shipped_date ? \Carbon\Carbon::parse($order->shipped_date)->format('d M, Y') : 'n/a' }}
                                </div>

                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice </b><br><br>
                                    <b>Order ID:</b> {{ $order->id }}<br>
                                    <b>Total:</b> {{ number_format($order->grand_total, 2) }}<br>
                                    <b>Status:</b>
                                    <span class="{{ $order->status === 'pending' ? 'text-danger' : ($order->status === 'shipped' ? 'text-info' : ($order->status === 'delivered' ? 'text-success' : 'text-danger')) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-3">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th width="100">Price</th>
                                    <th width="100">Qty</th>
                                    <th width="100">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($orderItems as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>${{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3" class="text-right">Subtotal:</th>
                                    <td>${{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Discount:</th>
                                    <td>${{ number_format($order->discount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Shipping:</th>
                                    <td>${{ number_format($order->shipping, 2) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Grand Total:</th>
                                    <td>${{ number_format($order->grand_total, 2) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <form action="{{ route('orders.changeOrderStatus', $order->id) }}" method="post" id="changeOrderStatusForm">
                            @csrf
                            <div class="card-body">
                                <h2 class="h4 mb-3">Order Status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="shipped_date">Shipped Date</label>
                                    <input value="{{ $order->shipped_date }}" type="datetime-local" name="shipped_date" id="shipped_date" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Order status updated successfully!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modalOkButton">OK</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datetimepicker@4.17.47/build/css/bootstrap-datetimepicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datetimepicker@4.17.47/build/js/bootstrap-datetimepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            var today = new Date();
            var year = today.getFullYear();
            var month = String(today.getMonth() + 1).padStart(2, '0');
            var day = String(today.getDate()).padStart(2, '0');
            var formattedToday = year + '-' + month + '-' + day + 'T00:00';

            $('#shipped_date').attr('min', formattedToday);
            $('#shipped_date').datetimepicker({
                format: 'Y-m-d H:i:s',
            });

            $("#changeOrderStatusForm").submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response); // Debugging
                        if (response.status) {
                            window.location.href = "{{ route('orders.index') }}"; // Redirect here
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('An error occurred while updating the order status.');
                    }
                });
            });
        });
    </script>


@endsection

