@extends('admin.layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <!-- Product Details Card -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{ old('title') }}">
                                    @error('title')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ old('slug') }}" readonly>
                                    @error('slug')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="short_description">Short Description</label>
                                    <textarea name="short_description" id="short_description" cols="30" rows="10" class="summernote" placeholder="">{{ old('short_description') }}</textarea>

                                </div>

                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description">{{ old('description') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="description">Shipping and Return</label>
                                    <textarea name="shipping_returns" id="shipping_returns" cols="30" rows="10" class="summernote" placeholder="">{{ old('shipping_returns') }}</textarea>
                                </div>


                            </div>
                        </div>

                        <!-- Media Card -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <label for="image">Image</label>
                                <div class="dropzone" id="imageDropzone">
                                    <div class="dz-message needsclick">
                                        Drop files here or click to upload.
                                    </div>
                                </div>
                                <input type="hidden" name="image" id="image" multiple>
                            </div>
                        </div>

                        <!-- Pricing Card -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" id="price" class="form-control" placeholder="Price" value="{{ old('price') }}">
                                    @error('price')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="compare_price">Compare at Price</label>
                                    <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price" value="{{ old('compare_price') }}">
                                    <p class="text-muted mt-3">
                                        To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Inventory Card -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>
                                <div class="mb-3">
                                    <label for="sku">SKU (Stock Keeping Unit)</label>
                                    <input type="text" name="sku" id="sku" class="form-control" placeholder="SKU" value="{{ old('sku') }}">
                                    @error('sku')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="barcode">Barcode</label>
                                    <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode" value="{{ old('barcode') }}">
                                    @error('barcode')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="hidden" name="track_qty" value="No">
                                        <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="Yes" {{ old('track_qty', 'No') === 'Yes' ? 'checked' : '' }}>
                                        <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                        @error('track_qty')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty" value="{{ old('qty') }}">
                                    @error('qty')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Product Status Card -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product Status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Block</option>
                                    </select>
                                    @error('status')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Category Selection Card -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category_id" id="category" class="form-control">
                                        <option value="">Select a Category</option>
                                        @if($categories->isNotEmpty())
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                    @error('category_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <span class="text-danger" id="category-error"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="sub_category">Sub Category</label>
                                    <select name="sub_category_id" id="sub_category" class="form-control">
                                        <option value="">Select a Sub Category</option>
                                        <!-- Subcategories will be populated via AJAX -->
                                    </select>
                                    @error('sub_category_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <span class="text-danger" id="subcategory-error"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Brand Selection Card -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product Brand</h2>
                                <div class="mb-3">
                                    <select name="brand_id" id="brand" class="form-control">
                                        <option value="">Select Brand</option>
                                        @if($brands->isNotEmpty())
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                    @error('brand_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Featured Product Selection Card -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured Product</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="featured" class="form-control">
                                        <option value="">Select Feature</option>
                                        <option value="No" {{ old('is_featured') == 'No' ? 'selected' : '' }}>No</option>
                                        <option value="Yes" {{ old('is_featured') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    @error('is_featured')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('customjs')
    <script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/dropzone/dropzone.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize summernote
            $('.summernote').summernote({
                height: 150,
                minHeight: null,
                maxHeight: null,
                focus: true
            });

            // Event listener for category dropdown change
            $('#category').change(function() {
                let categoryId = $(this).val();

                if (categoryId) {
                    // AJAX request to fetch subcategories
                    $.ajax({
                        url: '{{ route('product.subcategories.index') }}',
                        type: 'GET',
                        data: {
                            category_id: categoryId
                        },
                        success: function(response) {
                            // Populate the subcategory dropdown
                            let subCategoryDropdown = $('#sub_category');
                            subCategoryDropdown.empty();
                            subCategoryDropdown.append('<option value="">Select a Sub Category</option>');

                            if (response.status) {
                                $.each(response.subCategories, function(key, subCategory) {
                                    subCategoryDropdown.append('<option value="' + subCategory.id + '">' + subCategory.name + '</option>');
                                });
                            } else {
                                subCategoryDropdown.append('<option value="">No Subcategories available</option>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                            $('#sub_category').empty().append('<option value="">Error loading subcategories</option>');
                        }
                    });
                } else {
                    // Clear the subcategory dropdown if no category is selected
                    $('#sub_category').empty();
                    $('#sub_category').append('<option value="">Select a Sub Category</option>');
                }
            });

            // Function to generate a slug from the title
            function generateSlug(text) {
                return text
                    .toString()                     // Convert to string
                    .normalize('NFD')              // Normalize Unicode
                    .replace(/[\u0300-\u036f]/g, '') // Remove accents
                    .toLowerCase()                 // Convert to lowercase
                    .replace(/\s+/g, '-')          // Replace spaces with -
                    .replace(/[^\w\-]+/g, '')      // Remove all non-word characters
                    .replace(/\-\-+/g, '-')        // Replace multiple - with single -
                    .replace(/^-+/, '')            // Remove leading -
                    .replace(/-+$/, '');           // Remove trailing -
            }

            // Event listener for the title field change
            $('#title').on('input', function() {
                let title = $(this).val();
                $('#slug').val(generateSlug(title));
            });
        });


        Dropzone.autoDiscover = false;

        const dropzone = new Dropzone("#imageDropzone", {
            url: "{{ route('temp-images.store') }}",
            maxFiles: 2,
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
