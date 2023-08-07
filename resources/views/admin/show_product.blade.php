<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    @include('admin.css')

    <style type="text/css">
        .h2_font {
            font-size: 40px;
            padding-bottom: 40px;
            text-align: center;
        }

        .img_size {
            width: 150px;
            height: 150px;
        }

        .th_color {
            background: skyblue;
        }

        .th_deg {
            padding: 15px;
        }

        .center {
            margin: auto;
            text-align: center;
            margin-top: 40px;
            border: 3px solid white;
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

                    <h2 class="h2_font">All Product</h2>
                    @if (session()->has('message_edit'))
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            {{ session()->get('message_edit') }}
                        </div>
                    @elseif (session()->has('message_delete'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            {{ session()->get('message_delete') }}
                        </div>
                    @endif

                    <table class="center">
                        <tr class="th_color">
                            <td class="th_deg">No</td>
                            <td class="th_deg">Title</td>
                            <td class="th_deg">Description</td>
                            <td class="th_deg">Quantity</td>
                            <td class="th_deg">Category</td>
                            <td class="th_deg">Price</td>
                            <td class="th_deg">Discount Price</td>
                            <td class="th_deg">Image</td>
                            <td class="th_deg">Action</td>
                        </tr>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->category }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->discount_price }}</td>
                                <td><img src="/product/{{ $product->image }}" alt="null" class="img_size"></td>
                                <td>
                                    <a href="{{ url('update_product', $product->id) }}" class="badge bg-warning"><i
                                            class="bi bi-pencil-square"></i></a>
                                    <form action="{{ url('delete_product', $product->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button class="badge bg-danger border-0"
                                            onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data ?')"><i
                                                class="bi bi-x-square"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
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
