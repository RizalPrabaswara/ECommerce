<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    @include('admin.css')

    <style type="text/css">
        .div_center {
            text-align: center;
            padding-top: 40px;
        }

        .h2_font {
            font-size: 40px;
            padding-bottom: 40px;
        }

        .input_color {
            color: black;
        }

        label {
            display: inline-block;
            width: 200px;
        }

        .preview_gambar {
            display: inline-block;
            width: 200px;
            overflow: hidden;
        }

        .div_design {
            padding-bottom: 15px;
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

                    <div class="div_center">
                        <h2 class="h2_font">Add Product</h2>

                        <form action="{{ url('/add_product') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="div_design">
                                <label>Title</label>
                                <input type="text" class="input_color" id="title" name="title"
                                    placeholder="Write a Title" required autofocus>
                            </div>
                            <div class="div_design">
                                <label>Description</label>
                                <input type="text" class="input_color" id="description" name="description"
                                    placeholder="Write a description" required>
                            </div>
                            <div class="div_design">
                                <label>Price</label>
                                <input type="number" class="input_color" id="price" name="price"
                                    placeholder="Write a price" required>
                            </div>
                            <div class="div_design">
                                <label>Discount Price</label>
                                <input type="number" class="input_color" id="discount_price" name="discount_price"
                                    placeholder="Write a Discount Price">
                            </div>
                            <div class="div_design">
                                <label>Quantitiy</label>
                                <input type="number" class="input_color" id="quantity" name="quantity" min="0"
                                    placeholder="Write a quantity" required>
                            </div>
                            <div class="div_design">
                                <label>Category</label>
                                <select class="input_color" name="category" id="category" required>
                                    <option value="" selected disabled>Add a Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="div_design">
                                <label>Product Image</label>
                                <div>
                                    <img src="" class="preview_gambar" id="frame">
                                </div>
                                <br />
                                <input type="file" id="image" name="image" onchange="preview()" required>
                            </div>

                            <input type="submit" class="btn btn-primary" name="submit" value="Add Product">
                        </form>
                    </div>

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
    <script>
        function preview() {
            frame.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
</body>

</html>
