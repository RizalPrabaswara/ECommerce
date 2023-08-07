<section class="product_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <br><br>

            <div>
                <form action="{{ url('product_search1') }}" method="GET">
                    @csrf
                    <input style="width: 500px;" type="text" name="search" id="search"
                        placeholder="Search For Something">

                    <input type="submit" value="Search">
                </form>
            </div>
        </div>

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

        <div class="row">
            @foreach ($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="box">
                        <div class="option_container">
                            <div class="options">
                                <a href="{{ url('product_details', $product->id) }}" class="option1">
                                    Product Detail
                                </a>

                                <form action="{{ url('add_cart', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="number" name="quantity" id="quantity" value="1"
                                                min="1" style="width: 100px;">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="submit" value="Add to Cart">
                                        </div>
                                    </div>
                                </form>

                                {{-- <a href="" class="option2">
                                    Buy Now
                                </a> --}}
                            </div>
                        </div>
                        <div class="img-box">
                            <img src="product/{{ $product->image }}" alt="">
                        </div>
                        <div class="detail-box">
                            <div class="col-6">
                                <h5>
                                    {{ $product->title }}
                                </h5>
                            </div>
                            <div class="col">
                                @if ($product->discount_price != null)
                                    <div class="col-6">
                                        <h6 style="color: red">
                                            Discount Price
                                            <br />
                                            ${{ $product->discount_price }}
                                        </h6>
                                    </div>
                                    <div class="col-6">
                                        <h6 style="text-decoration: line-through; color:blue">
                                            Price
                                            <br />
                                            ${{ $product->price }}
                                        </h6>
                                    </div>
                                @else
                                    <h6 style="color:blue">
                                        Price
                                        <br />
                                        ${{ $product->price }}
                                    </h6>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="heading_container heading_center">
            <span style="padding-top: 40px; margin-top:20px;">
                {!! $products->links() !!}
            </span>
        </div>
        {{-- <div class="btn-box">
            <a href="">
                View All products
            </a>
        </div> --}}
    </div>
</section>
