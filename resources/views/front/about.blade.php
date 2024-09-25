@extends('front.layout.app')
@section('content')

    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item">About Us</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-10">
        <div class="container">
            <h1 class="my-3">About Us</h1>
            <p>Welcome to Online-Shop , your go-to destination for [product type]! Our journey began with a simple vision: to provide high-quality products at affordable prices while offering an exceptional shopping experience. Over the years, we have built a loyal customer base and expanded our product lines to cater to your every need.</p>

            <p>At Online-Shop, we believe in more than just selling products. We are committed to building a community around our brand, focusing on customer satisfaction, trust, and long-term relationships. From sourcing the best materials to ensuring a seamless checkout experience, every detail is crafted with you in mind.</p>

            <p>What sets us apart? Our dedication to quality and service. Every item in our store is carefully curated, and we work with trusted suppliers to guarantee that you receive the best. Our customer support team is always ready to assist you, whether it's answering a query, helping with a return, or providing guidance on choosing the perfect product.</p>

            <p>As a forward-thinking company, we also believe in sustainable practices. From eco-friendly packaging to promoting ethical sourcing, we strive to minimize our environmental footprint while still delivering excellence. Your purchases not only bring joy to you but also contribute to a more sustainable future.</p>

            <p>Thank you for choosing Online-Shop. We look forward to serving you and being part of your shopping journey. Stay tuned for exciting new arrivals, exclusive deals, and much more!</p>

            <p>If you have any questions or feedback, don't hesitate to <a href="#">contact us</a>.</p>
        </div>
    </section>

@endsection

@section('customjs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
