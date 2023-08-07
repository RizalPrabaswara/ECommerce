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

</head>

<body>
    <div class="hero_area">
        <!-- Header section -->
        @include('home.header')
        <!-- End Header section -->

        <div class="col-sm-6 col-md-4 col-lg-4" style="margin: auto; width: 50%; padding: 30px">
            <div class="box">
                <div class="img-box" style="padding: 20px;">
                    <img src="/product/{{ $product->image }}" alt="">
                </div>
                <div class="detail-box">
                    <div class="row">
                        <div class="col">
                            <h5>
                                {{ $product->title }}
                            </h5>
                        </div>
                        <div class="col-6">
                            @if ($product->discount_price != null)
                                <div class="">
                                    <h6 style="color: red">
                                        Discount Price
                                        <br />
                                        ${{ $product->discount_price }}
                                    </h6>
                                </div>
                                <div class="">
                                    <h6 style="text-decoration: line-through; color:blue">
                                        Price
                                        <br />
                                        ${{ $product->price }}
                                    </h6>
                                </div>
                            @else
                                <h6 style="text-decoration: line-through; color:blue">
                                    Price 123
                                    <br />
                                    ${{ $product->price }}
                                </h6>
                            @endif
                        </div>
                        <h6>Product Category : {{ $product->category }}</h6>
                        <h6>Product Description : {{ $product->description }}</h6>
                        <h6>Product Quantity : {{ $product->quantity }}</h6>
                        <br />
                    </div>
                </div>
            </div>
            <form action="{{ url('add_cart', $product->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <input type="number" name="quantity" id="quantity" value="1" min="1"
                            style="width: 100px;">
                    </div>
                    <div class="col-md-4">
                        <input type="submit" value="Add to Cart">
                    </div>
                </div>
            </form>
        </div>

    </div>


    <!-- footer start -->
    @include('home.footer')
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
</body>

</html>
