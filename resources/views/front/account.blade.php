@extends('front.layout.app')
@section('content')


    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('front.accountsidebar')
                </div>
{{--                <div class="col-md-9">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-header">--}}
{{--                            <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>--}}
{{--                        </div>--}}
{{--                        <div class="card-body p-4">--}}
{{--                            <div class="row">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label for="name">Old Password</label>--}}
{{--                                    <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">--}}
{{--                                </div>--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label for="name">New Password</label>--}}
{{--                                    <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control">--}}
{{--                                </div>--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label for="name">Confirm Password</label>--}}
{{--                                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Old Password" class="form-control">--}}
{{--                                </div>--}}
{{--                                <div class="d-flex">--}}
{{--                                    <button class="btn btn-dark">Save</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </section>


@endsection
@section('customjs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection

