<!DOCTYPE html>
<html class="no-js" lang="en_AU" />

@include('front.layout.header')

@yield('content')

@include('front.layout.footer')


<script src="{{asset('front/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('front/js/bootstrap.bundle.5.1.3.min.js')}}"></script>
<script src="{{asset('front/js/instantpages.5.1.0.min.js')}}"></script>
<script src="{{asset('front/js/lazyload.17.6.0.min.js')}}"></script>
<script src="{{asset('front/js/slick.min.js')}}"></script>
<script src="{{asset('front/js/custom.js')}}"></script>
<script>
    window.onscroll = function() {myFunction()};

    var navbar = document.getElementById("navbar");
    var sticky = navbar.offsetTop;

    function myFunction() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky")
        } else {
            navbar.classList.remove("sticky");
        }
    }
</script>
<script>
    window.onscroll = function() {
        myFunction();
    };

    var navbar = document.getElementById("navbar");
    var sticky = navbar.offsetTop;

    function myFunction() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky");
        } else {
            navbar.classList.remove("sticky");
        }
    }


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    function addToCart(id) {
        $.ajax({
            {{--url: '{{ route("front.addToCart") }}',--}}
            url: '{{ route("cart.add") }}',
            type: 'post',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response.status === true) {
                    {{--window.location.href = "{{ route('front.cart') }}";--}}
                        window.location.href = "{{ route('cart.index') }}";
                } else {
                    console.log('test',response.message)
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred while adding the item to the cart.');
            }
        });
    }

</script>

@yield('customjs')
</body>
</html>
