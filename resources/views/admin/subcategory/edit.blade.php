@extends('admin.layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Sub Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('subcategories.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <!-- Success message -->
                    <div id="success-message" class="alert alert-success d-none">
                        SubCategory has been updated successfully
                    </div>

                    <form id="subcategory-form" action="{{ route('subcategories.update', $subCategory->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category_id" id="category" class="form-control">
                                        <option value="">Select a Category</option>
                                        @if($categories->isNotEmpty())
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $subCategory->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="text-danger" id="category-error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ old('name', $subCategory->name) }}" required>
                                    <span class="text-danger" id="name-error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ old('slug', $subCategory->slug) }}"  required>
                                    <span class="text-danger" id="slug-error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="1" {{ $subCategory->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $subCategory->status == 0 ? 'selected' : '' }}>Block</option>
                                    </select>
                                    <span class="text-danger" id="status-error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="showhome">Show on Home</label>
                                    <select name="showhome" id="showhome" class="form-control">
                                        <option value="No" {{ $subCategory->showhome == 'No' ? 'selected' : '' }}>No</option>
                                        <option value="Yes" {{ $subCategory->showhome == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    <span class="text-danger" id="showhome-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5 pt-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('subcategories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            // Slug generation based on name input
            $('#name').on('input', function() {
                let name = $(this).val();
                let slug = name.toLowerCase()
                    .replace(/[^\w\s-]/g, '')  // Remove invalid characters
                    .trim()                    // Trim leading/trailing whitespace
                    .replace(/[\s_-]+/g, '-')  // Replace spaces and underscores with hyphens
                    .replace(/^-+|-+$/g, '');  // Remove leading/trailing hyphens
                $('#slug').val(slug);
            });

            // Handle form submission with AJAX
            $('#subcategory-form').on('submit', function(e) {
                e.preventDefault();

                // Clear previous error messages
                $('.text-danger').text('');

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status) {
                            // Display success message
                            $('#success-message').removeClass('d-none').text(response.message);
                            // Redirect to subcategories index after a delay
                            setTimeout(function() {
                                window.location.href = "{{ route('subcategories.index') }}";
                            }, 2000);
                        } else {
                            // Display validation errors
                            let errors = response.errors;
                            if (errors.category_id) {
                                $('#category-error').text(errors.category_id[0]);
                            }
                            if (errors.name) {
                                $('#name-error').text(errors.name[0]);
                            }
                            if (errors.slug) {
                                $('#slug-error').text(errors.slug[0]);
                            }
                            if (errors.status) {
                                $('#status-error').text(errors.status[0]);
                            }
                            if (errors.showhome) {
                                $('#showhome-error').text(errors.showhome[0]);
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
