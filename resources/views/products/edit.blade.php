<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crud Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<div class="bg-dark py-3">
    <h3 class="text-white text-center">Crud Products</h3>
</div>
<div class="container">
    <div class="row justify-content-center mt-4" >
        <div class="col-md-10 d-flex justify-content-end">
            <a href="{{route('products.index')}}" class="btn btn-dark">Back</a>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-md-18">
            <div class="card borde-0 shadow-lg my-4">
                <div class="card-header bg-dark">
                    <h3 class="text-white">Edit Product</h3>
                </div>
                <form enctype="multipart/form-data" action="{{ route('products.update', $product->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="" class="form-label h4">Name</label>
                            <input value="{{old('name',$product->name)}}" type="text" class="@error('name')is-invalid @enderror form-control form-control-lg" placeholder="Name" name="name">
                            @error('name')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label h4">Sku</label>
                            <input value="{{old('sku',$product->sku)}}" type="text" class="@error('sku')is-invalid @enderror form-control form-control-lg" placeholder="Sku" name="sku">
                            @error('sku')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label h4">Price</label>
                            <input value="{{old('price',$product->price)}}" type="text" class="@error('price')is-invalid @enderror form-control form-control-lg" placeholder="Price" name="price">
                            @error('price')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label h4">Description</label>
                            <textarea class="form-control form-control-lg" placeholder="Description" name="description" id="description">{{old('description')}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label h4">Image</label>
                            <input type="file" class="form-control form-control-lg" placeholder="Image" name="image">
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-lg btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
