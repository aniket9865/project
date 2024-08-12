@extends('admin.layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('categories.update', $category->id) }}" method="post" id="categoryForm" name="categoryForm">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $category->name }}">
                                    <p id="nameError" class="error text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" readonly value="{{ $category->slug }}">
                                    <p id="slugError" class="error text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Block</option>
                                    </select>
                                    <p id="statusError" class="error text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="showhome">Show home</label>
                                    <select name="showhome" id="showhome" class="form-control">
                                        <option value="No" {{ $category->showhome == 'No' ? 'selected' : '' }}>No</option>
                                        <option value="Yes" {{ $category->showhome == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    <p id="showhomeError" class="error text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image">Image</label>
                                    <div class="dropzone" id="imageDropzone">
                                        <div class="dz-message needsclick">
                                            Drop files here or click to upload.
                                        </div>
                                    </div>
                                    <input type="hidden" name="image" id="image" value="{{ $category->image }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            $("#categoryForm").submit(function(event) {
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

                // Validate slug
                const slug = $("#slug").val().trim();
                if (!slug) {
                    $("#slug").addClass('is-invalid');
                    $("#slugError").text('Slug is required.');
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
                        url: '{{ route("categories.update", $category->id) }}', // Update URL to use the update route
                        type: 'post',
                        data: new FormData(this), // Use FormData to include file uploads
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                alert('Category updated successfully!');
                                window.location.href = '{{ route("categories.index") }}';
                            } else {
                                const errors = response.errors;
                                if (errors.name) {
                                    $('#name').addClass('is-invalid')
                                        .siblings('.error').text(errors.name[0]);
                                }
                                if (errors.slug) {
                                    $('#slug').addClass('is-invalid')
                                        .siblings('.error').text(errors.slug[0]);
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

        Dropzone.autoDiscover = false;

        const dropzone = new Dropzone("#imageDropzone", {
            url: "{{ route('temp-images.store') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                // Store the image path in a hidden input
                $("#image").val(response.image_path);
            },
            removedfile: function(file) {
                // Remove the file preview.
                file.previewElement.remove();

                // Remove image path from hidden input
                $("#image").val('');

                // Optionally send a request to delete the file from the server
                $.ajax({
                    url: '{{ route("temp-images.delete") }}',
                    type: 'post',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        image_path: $("#image").val()
                    },
                    success: function(response) {
                        console.log(response.message);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("Something went wrong: ", textStatus, errorThrown);
                    }
                });
            },
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });

                // If you have an existing image, show it
                const existingImage = $("#image").val();
                if (existingImage) {
                    const mockFile = { name: existingImage, size: 12345 }; // Provide size if necessary
                    this.emit('addedfile', mockFile);
                    this.emit('thumbnail', mockFile, '{{ asset('uploads/temp') }}/' + existingImage);
                    this.emit('complete', mockFile);
                }
            }
        });
    </script>
@endsection

