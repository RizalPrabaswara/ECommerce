<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="images/favicon.png" type="">
    <title>Famms - Fashion HTML Template</title>
    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('home/css/bootstrap.css') }}" />
    <!-- font awesome style -->
    <link href="{{ asset('home/css/font-awesome.min.css') }}" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" />

    <style type="text/css">
        .center {
            margin: auto;
            width: 70%;
            text-align: center;
            padding: 30px;
        }

        table,
        th,
        td {
            border: 1px solid gray;
        }

        .th_deg {
            font-size: 30px;
            padding: 5px;
            background: skyblue;
        }

        .img_deg {
            height: 200px;
            width: 200px;
        }

        .total_deg {
            font-size: 20px;
            padding: 40px;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    @include('sweetalert::alert')

    <div class="hero_area">
        <!-- Header section -->
        @include('home.header')
        <!-- End Header section -->

        @if (session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('message') }}
            </div>
        @elseif (session()->has('message_delete'))
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('message_delete') }}
            </div>
        @endif

        <div class="center">
            <table>
                <tr>
                    <th class="th_deg">Product Title</th>
                    <th class="th_deg">Product Quantity</th>
                    <th class="th_deg">Price</th>
                    <th class="th_deg">Image</th>
                    <th class="th_deg">Action</th>
                </tr>

                <?php $totalprice = 0; ?>

                @foreach ($carts as $cart)
                    <tr>
                        <td>{{ $cart->product_title }}</td>
                        <td>{{ $cart->quantity }}</td>
                        <td>${{ $cart->price }}</td>
                        <td><img class="img_deg" src="/product/{{ $cart->image }}" alt=""></td>
                        <td><a class="btn btn-danger" href="{{ url('remove_cart', $cart->id) }}"
                                onclick="confirmation(event)">Remove Product</a>
                        </td>
                    </tr>

                    <?php $totalprice = $totalprice + $cart->price; ?>
                @endforeach
            </table>

            <br />
            <div>
                <h1 class="total_deg">TOTAL PRICE = ${{ $totalprice }}</h1>
            </div>
            <br />
            <div>
                <h1 style="font-size: 25px; padding-bottom:15px;">Proceed to Order</h1>
                <a href="{{ url('cash_order') }}" class="btn btn-danger">Cash On Delivery</a>
                <a href="{{ url('stripe', $totalprice) }}" class="btn btn-danger">Pay Using Card</a>
            </div>
        </div>

    </div>

    <!-- footer start -->

    <!-- footer end -->
    <div class="cpy_">
        <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

        </p>
    </div>
    <!-- jQery -->
    <script src="{{ asset('home/js/jquery-3.4.1.min.js') }}"></script>
    <!-- popper js -->
    <script src="{{ asset('home/js/popper.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('home/js/bootstrap.js') }}"></script>
    <!-- custom js -->
    <script src="{{ asset('home/js/custom.js') }}"></script>

    <script>
        function confirmation(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href');
            console.log(urlToRedirect);
            swal({
                    title: "Are you sure to cancel this product",
                    text: "You will not be able to revert this!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willCancel) => {
                    if (willCancel) {
                        window.location.href = urlToRedirect;
                    }
                });
        }
    </script>
</body>

</html>
