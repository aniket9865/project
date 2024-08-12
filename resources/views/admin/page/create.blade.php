{{--@extends('admin.layout.app')--}}
{{--@section('content')--}}
{{--    <!-- Content Header (Page header) -->--}}
{{--    <section class="content-header">--}}
{{--        <div class="container-fluid my-2">--}}
{{--            <div class="row mb-2">--}}
{{--                <div class="col-sm-6">--}}
{{--                    <h1>Create Page</h1>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6 text-right">--}}
{{--                    <a href="{{route('pages.index')}}" class="btn btn-primary">Back</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- /.container-fluid -->--}}
{{--    </section>--}}
{{--    <!-- Main content -->--}}
{{--    <section class="content">--}}
{{--        <!-- Default box -->--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="name">Name</label>--}}
{{--                                <input type="text" name="name" id="name" class="form-control" placeholder="Name">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="email">Slug</label>--}}
{{--                                <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-12">--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="content">Content</label>--}}
{{--                                <textarea name="content" id="content" class="summernote" cols="30" rows="10"></textarea>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="pb-5 pt-3">--}}
{{--                <button class="btn btn-primary">Create</button>--}}
{{--                <a href="pages.html" class="btn btn-outline-dark ml-3">Cancel</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- /.card -->--}}
{{--    </section>--}}
{{--    <!-- /.content -->--}}
{{--@endsection--}}

{{--@section('costomjs')--}}
{{--    <script>--}}

{{--    </script>--}}
{{--@endsection--}}

@extends('admin.layouts.app')

@section('content')
    <h1>Create Page</h1>
    <form action="{{ route('page.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" name="content" id="content" required>{{ old('content') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Page</button>
    </form>
@endsection
