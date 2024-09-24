@extends('admin.layout.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between mb-4">
                    <h1>Shipping Charges</h1>
                    <a href="{{ route('shipping.create') }}" class="btn btn-primary">Add Shipping Charge</a>
                </div>
                {{-- Search Form --}}
                <form method="GET" action="{{ route('shipping.index') }}" class="mb-4" id="searchForm">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by country name" value="{{ request()->input('search') }}">
                        <button class="btn btn-primary" type="submit">Search</button>
                        <button class="btn btn-secondary" type="button" onclick="resetSearch()">Reset</button>
                    </div>

                </form>

                {{-- Table of Shipping Charges --}}
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Country</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($shippingCharges as $shippingCharge)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $shippingCharge->country->name }}</td>
                            <td>Rs{{ number_format($shippingCharge->amount, 2) }}</td>
                            <td>
                                <a href="{{ route('shipping.edit', $shippingCharge->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="deleteShippingCharge({{ $shippingCharge->id }})">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No shipping charges found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $shippingCharges->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Script --}}
    <script>
        function deleteShippingCharge(id) {
            if (confirm('Are you sure you want to delete this shipping charge?')) {
                $.ajax({
                    url: `/admin/shipping/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while deleting the shipping charge.');
                    }
                });
            }
        }

        function resetSearch() {
            const form = document.getElementById('searchForm');
            form.reset();
            // Redirect to the base route without search parameters
            window.location.href = "{{ route('shipping.index') }}";
        }
    </script>
@endsection
