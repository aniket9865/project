<!DOCTYPE html>
<html class="no-js" lang="en_AU" />

@include('front.layout.header')

@yield('content')

@include('front.layout.footer')
<!-- Wishlist Modal -->
<div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="wishlistModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wishlistModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Success message or content will be injected here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


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

<script>
    function addToWishList(id) {
        $.ajax({
            url: '{{ route("front.addToWishlist", ":id") }}'.replace(':id', id),
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' }, // Include CSRF token
            dataType: 'json',
            success: function(response) {
                if (response.status === true) {
                    // Inject success message into modal
                    $('#wishlistModal .modal-body').html('<div class="alert alert-success"><strong>Success:</strong> ' + response.message + '</div>');
                    // Show the modal
                    $('#wishlistModal').modal('show');
                } else {
                    // Inject error message into modal
                    $('#wishlistModal .modal-body').html('<div class="alert alert-danger"><strong>Error:</strong> ' + response.message + '</div>');
                    // Show the modal
                    $('#wishlistModal').modal('show');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                $('#wishlistModal .modal-body').html('<div class="alert alert-danger"><strong>Error:</strong> An error occurred while adding the item to the wishlist.</div>');
                $('#wishlistModal').modal('show');
            }
        });
    }
</script>



@yield('customjs')
</body>
</html>
