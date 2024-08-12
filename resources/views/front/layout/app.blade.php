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


</script>

@yield('customjs')
</body>
</html>
