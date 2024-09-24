<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no">

    <meta name="HandheldFriendly" content="True">
    <meta name="pinterest" content="nopin">

    <meta property="og:locale" content="en_AU">
    <meta property="og:type" content="website">
    <meta property="fb:admins" content="">
    <meta property="fb:app_id" content="">
    <meta property="og:site_name" content="">
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="">
    <meta property="og:image:height" content="">
    <meta property="og:image:alt" content="">

    <meta name="twitter:title" content="">
    <meta name="twitter:site" content="">
    <meta name="twitter:description" content="">
    <meta name="twitter:image" content="">
    <meta name="twitter:image:alt" content="">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="stylesheet" type="text/css" href="{{ asset('front/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front/css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front/css/video-js.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front/css/style.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">

    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="#">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body data-instant-intensity="mousedown">

<div class="bg-light top-header">
    <div class="container">
        <div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
            <div class="col-lg-4 logo">
                <a href="{{ url('/') }}" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">Online</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">SHOP</span>
                </a>
            </div>

            <!-- Add this snippet where you want the search form to appear -->
            <div class="col-lg-6 col-6 text-left d-flex justify-content-end align-items-center">
                <a href="{{ route('front.account') }}" class="nav-link text-dark">My Account</a>
                <div class="d-flex align-items-center mb-4" style="margin-top: 18px;">
                    <form class="d-flex w-100" method="GET" action="{{ route('front.shop') }}">
                        <input class="form-control me-2" type="search" name="search" placeholder="Search products" aria-label="Search" value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

<header class="bg-dark">
    <div class="container">
        <nav class="navbar navbar-expand-xl" id="navbar">
            <a href="{{ url('/') }}" class="text-decoration-none mobile-logo">
                <span class="h2 text-uppercase text-primary bg-dark">Online</span>
                <span class="h2 text-uppercase text-white px-2">SHOP</span>
            </a>
            <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="navbar-toggler-icon fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if(getCategories()->isNotEmpty())
                        @foreach(getCategories() as $category)
                            <li class="nav-item dropdown">
                                <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $category->name }}
                                </button>
                                @if($category->sub_category->isNotEmpty())
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        @foreach($category->sub_category as $subCategory)
                                            <li><a class="dropdown-item nav-link" href="{{route('front.shop',[$category->slug,$subCategory->slug,])}}">{{$subCategory->name}}</a></li>
                                        @endforeach
                                    </ul>
                                @endif

                                    <!-- Example subcategories, replace with real data -->
                                    <!-- <li><a class="dropdown-item nav-link" href="#">Mobile</a></li>
                                    <li><a class="dropdown-item nav-link" href="#">Tablets</a></li>
                                    <li><a class="dropdown-item nav-link" href="#">Laptops</a></li>
                                    <li><a class="dropdown-item nav-link" href="#">Speakers</a></li>
                                    <li><a class="dropdown-item nav-link" href="#">Watches</a></li> -->

                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="right-nav py-0">
                <a href="{{ route('cart.index') }}" class="ml-3 d-flex pt-2">
                    <i class="fas fa-shopping-cart text-primary"></i>
                </a>
            </div>
        </nav>
    </div>
</header>




