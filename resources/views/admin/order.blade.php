<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    @include('admin.css')

    <style type="text/css">
        .h2_font {
            font-size: 20px;
            padding-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }

        .img_size {
            width: 200px;
            height: 100px;
        }

        .th_color {
            background: skyblue;
        }

        .th_deg {
            padding: 10px;
        }

        .center {
            margin: auto;
            width: 100%;
            text-align: center;
            margin-top: 40px;
            border: 2px solid white;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            @include('admin.header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">

                    <h2 class="h2_font">All Orders</h2>
                    @if (session()->has('message_deliver'))
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            {{ session()->get('message_deliver') }}
                        </div>
                    @elseif (session()->has('message_delete'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            {{ session()->get('message_delete') }}
                        </div>
                    @endif

                    <div style="padding-left: 400px; padding-bottom: 30px;">
                        <form action="{{ url('search') }}" method="GET">
                            @csrf
                            <input type="text" name="search" id="search" placeholder="Search For Something"
                                style="color: black;">

                            <input type="submit" value="Search" class="btn btn-outline-primary">
                        </form>
                    </div>

                    <table class="center">
                        <tr class="th_color">
                            <td class="th_deg">No</td>
                            <td class="th_deg">Name</td>
                            <td class="th_deg">Product Title</td>
                            <td class="th_deg">Quantity</td>
                            <td class="th_deg">Price</td>
                            <td class="th_deg">Image</td>
                            <td class="th_deg">Payment Status</td>
                            <td class="th_deg">Deliver Status</td>
                            <td class="th_deg">Delivered</td>
                            <td class="th_deg">Print PDF</td>
                            <td class="th_deg">Send Email</td>
                        </tr>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->product_title }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ $order->price }}</td>
                                <td><img src="/product/{{ $order->image }}" alt="null" class="img_size"></td>
                                <td>{{ $order->payment_status }}</td>
                                <td>{{ $order->delivery_status }}</td>
                                <td>
                                    @if ($order->delivery_status == 'Processing')
                                        <a href="{{ url('delivered', $order->id) }}" class="btn btn-primary"
                                            onclick="return confirm('Are You Sure Already Delivered ?')">Delivered</a>
                                    @else
                                        <p>Delivered</p>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('print_pdf', $order->id) }}" class="btn btn-secondary">Print
                                        PDF</a>
                                </td>
                                <td>
                                    <a href="{{ url('send_email', $order->id) }}" class="btn btn-info">Send Email</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="16">
                                    No Data Found
                                </td>
                            </tr>
                        @endforelse
                    </table>

                </div>
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
</body>

</html>
