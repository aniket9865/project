@extends('admin.layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('products.create') }}" class="btn btn-primary">New Product</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <form id="search-form" method="GET" action="{{ route('products.index') }}">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary" id="reset-button">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th width="80"></th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>SKU</th>
                            <th width="100">Status</th>
                            <th width="100">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($products as $product)
                            <tr id="product-row-{{ $product->id }}">
                                <td>{{ $product->id }}</td>
                                <td>@if($product->image)
                                        <img width="50" src="{{ asset('uploads/temp/' . $product->image) }}">
                                    @endif
                                </td>
                                <td>{{$product->title}}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->qty }} left in stock</td>
                                <td>{{ $product->sku }}</td>
                                <td>
                                    @if ($product->status == 1)
                                        <svg class="text-success h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @else
                                        <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('products.edit', $product->id) }}" class="text-primary edit-product" data-id="{{ $product->id }}">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </a>
                                    <a href="#" class="text-danger delete-product" data-id="{{ $product->id }}">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                    <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No products found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            // Handle AJAX Delete
            $('.delete-product').on('click', function(e) {
                e.preventDefault();
                let productId = $(this).data('id');
                if (confirm('Are you sure you want to delete this product?')) {
                    $.ajax({
                        url: `/admin/products/${productId}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                $(`#product-row-${productId}`).remove();
                                alert(response.message);
                            } else {
                                alert('Error deleting product');
                            }
                        },
                        error: function() {
                            alert('Error deleting product');
                        }
                    });
                }
            });

            // Handle AJAX Edit (Optional: if you want to handle in-line editing)
            $('.edit-product').on('click', function(e) {
                e.preventDefault();
                let productId = $(this).data('id');
                window.location.href = `/admin/products/${productId}/edit`;
            });

            // Handle Reset Button Click
            $('#reset-button').on('click', function() {
                $('#search-form')[0].reset(); // Reset the form
                window.location.href = "{{ route('products.index') }}"; // Redirect to the same page without query
            });
        });
    </script>
@endsection
