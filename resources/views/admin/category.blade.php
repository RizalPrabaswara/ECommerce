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

        .center {
            margin: auto;
            width: 50%;
            text-align: center;
            margin-top: 30px;
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

                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            {{ session()->get('message') }}
                        </div>
                    @elseif (session()->has('message_edit'))
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

                    <div class="div_center">
                        <h2 class="h2_font">Add Category</h2>

                        <form action="{{ url('/add_category') }}" method="POST">
                            @csrf
                            <input type="text" class="input_color" name="category" id="category"
                                placeholder="Write Category Name">

                            <input type="submit" class="btn btn-primary" name="submit" value="Add Category">
                        </form>
                    </div>

                    <table class="center">
                        <tr>
                            <td>No</td>
                            <td>Category Name</td>
                            <td>Action</td>
                        </tr>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->category_name }}</td>
                                <td>
                                    {{-- <a href="" class="badge bg-info"><i class="bi bi-eye"></i></a> --}}
                                    <button type="button" class="badge bg-warning border-0" data-toggle="modal"
                                        data-target="#ModalUbah{{ $category->id }}"><i
                                            class="bi bi-pencil-square"></i></button>
                                    <form action="{{ url('delete_category', $category->id) }}" method="POST"
                                        class="d-inline">
                                        {{-- @method('delete') --}}
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

    <!-- Modal -->
    @foreach ($categories as $category)
        <div class="modal fade" id="ModalUbah{{ $category->id }}" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Data Category</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/update_category_confirm', $category->id) }}" method="POST">
                            @csrf
                            <input type="text" class="input_color" name="category" id="category"
                                placeholder="Write Category Name" value="{{ $category->category_name }}">

                            <input type="submit" class="btn btn-primary" name="submit" value="Ubah Category">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
</body>

</html>
