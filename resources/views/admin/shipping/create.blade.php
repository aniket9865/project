@extends('admin.layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Shipping Charge</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('shipping.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('shipping.store') }}" method="post" id="shippingForm">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <select name="country" id="country" class="form-control">
                                    <option value="">Select a Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
{{--                                    <option value="rest_of_world">Rest of the world</option>--}}
                                </select>
                                <span class="text-danger error" id="countryError"></span>
                            </div>

                            <div class="col-md-4">
                                <input type="text" name="amount" id="amount" class="form-control" placeholder="Amount">
                                <span class="text-danger error" id="amountError"></span>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <div class="text-center">
        <p class="font-weight-bold">Under Construction</p>
    </div>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            $("#shippingForm").submit(function(event) {
                event.preventDefault();

                // Clear previous errors
                $('.form-control').removeClass('is-invalid');
                $('.error').text('');

                let isValid = true;

                // Validate country
                const country = $("#country").val();
                if (!country) {
                    $("#country").addClass('is-invalid');
                    $("#countryError").text('Country is required.');
                    isValid = false;
                }

                // Validate amount
                const amount = $("#amount").val().trim();
                if (!amount || isNaN(amount)) {
                    $("#amount").addClass('is-invalid');
                    $("#amountError").text('Valid amount is required.');
                    isValid = false;
                }

                // If valid, submit form via AJAX
                if (isValid) {
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'post',
                        data: new FormData(this), // Use FormData to include file uploads
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                alert('Shipping charge created successfully!');
                                window.location.href = '{{ route("shipping.index") }}';
                            } else {
                                const errors = response.errors;
                                if (errors.country) {
                                    $('#country').addClass('is-invalid')
                                        .siblings('.error').text(errors.country[0]);
                                }
                                if (errors.amount) {
                                    $('#amount').addClass('is-invalid')
                                        .siblings('.error').text(errors.amount[0]);
                                }
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log("Something went wrong: ", textStatus, errorThrown);
                        }
                    });
                }
            });
        });
    </script>
@endsection

