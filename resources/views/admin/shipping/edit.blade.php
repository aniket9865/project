@extends('admin.layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Shipping Charge</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('shipping.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Shipping Charge Details</h3>
                </div>
                <div class="card-body">
                    <form id="edit-form" method="POST" action="{{ route('shipping.update', $shippingCharge->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select id="country" name="country" class="form-control @error('country') is-invalid @enderror">
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" {{ $shippingCharge->country_id == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" id="amount" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $shippingCharge->amount) }}">
                            @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update Shipping Charge</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            $('#edit-form').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        if (response.status) {
                            alert(response.message);
                            window.location.href = "{{ route('shipping.index') }}";
                        } else {
                            alert('Error updating shipping charge');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText); // Log error for debugging
                        alert('Error updating shipping charge');
                    }
                });
            });
        });
    </script>
@endsection
