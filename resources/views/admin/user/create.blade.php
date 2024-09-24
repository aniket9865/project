@extends('admin.layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create User</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('users.store') }}" method="post" id="userForm" name="userForm">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                    <p id="nameError" class="error text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                    <p id="emailError" class="error text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                    <p id="passwordError" class="error text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">
                                    <p id="passwordConfirmationError" class="error text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role">Role</label>
                                    <select name="role" id="role" class="form-control">
                                        <option value="customer">Customer</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                    <p id="roleError" class="error text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <p id="statusError" class="error text-danger"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            $("#userForm").submit(function(event) {
                event.preventDefault();

                // Clear previous errors
                $('.form-control').removeClass('is-invalid');
                $('.error').text('');

                let isValid = true;

                // Validate name
                const name = $("#name").val().trim();
                if (!name) {
                    $("#name").addClass('is-invalid');
                    $("#nameError").text('Name is required.');
                    isValid = false;
                }

                // Validate email
                const email = $("#email").val().trim();
                if (!email) {
                    $("#email").addClass('is-invalid');
                    $("#emailError").text('Email is required.');
                    isValid = false;
                }

                // Validate password
                const password = $("#password").val().trim();
                if (!password) {
                    $("#password").addClass('is-invalid');
                    $("#passwordError").text('Password is required.');
                    isValid = false;
                }

                // Validate password confirmation
                const passwordConfirmation = $("#password_confirmation").val().trim();
                if (password !== passwordConfirmation) {
                    $("#password_confirmation").addClass('is-invalid');
                    $("#passwordConfirmationError").text('Password confirmation does not match.');
                    isValid = false;
                }

                // Validate role
                const role = $("#role").val();
                if (!role) {
                    $("#role").addClass('is-invalid');
                    $("#roleError").text('Role is required.');
                    isValid = false;
                }

                // Validate status
                const status = $("#status").val();
                if (!status) {
                    $("#status").addClass('is-invalid');
                    $("#statusError").text('Status is required.');
                    isValid = false;
                }

                // If valid, submit form via AJAX
                if (isValid) {
                    $.ajax({
                        url: '{{ route("users.store") }}',
                        type: 'post',
                        data: new FormData(this), // Use FormData to include file uploads
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                alert('User created successfully!');
                                window.location.href = '{{ route("users.index") }}';
                            } else {
                                const errors = response.errors;
                                if (errors.name) {
                                    $('#name').addClass('is-invalid')
                                        .siblings('.error').text(errors.name[0]);
                                }
                                if (errors.email) {
                                    $('#email').addClass('is-invalid')
                                        .siblings('.error').text(errors.email[0]);
                                }
                                if (errors.password) {
                                    $('#password').addClass('is-invalid')
                                        .siblings('.error').text(errors.password[0]);
                                }
                                if (errors.password_confirmation) {
                                    $('#password_confirmation').addClass('is-invalid')
                                        .siblings('.error').text(errors.password_confirmation[0]);
                                }
                                if (errors.role) {
                                    $('#role').addClass('is-invalid')
                                        .siblings('.error').text(errors.role[0]);
                                }
                                if (errors.status) {
                                    $('#status').addClass('is-invalid')
                                        .siblings('.error').text(errors.status[0]);
                                }
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log("Something went wrong: ", textStatus, errorThrown);
                        }
                    });
                }
            });

            $("#name").on('input', function() {
                var element = $(this);
                var slug = element.val().trim().toLowerCase().replace(/[^a-z0-9]+/g, '-');
                $("#slug").val(slug);
            });
        });
    </script>
@endsection
