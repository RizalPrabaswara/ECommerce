<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/public">
    <!-- Required meta tags -->
    @include('admin.css')
    <style type="text/css">
        label {
            display: inline-block;
            width: 200px;
            font-size: 15px;
            font-weight: bold;
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

                    <h1 style="text-align: center; font-size: 25px;">Send Email to {{ $order->email }}</h1>

                    <form action="{{ url('send_user_email', $order->id) }}" method="POST">
                        @csrf
                        <div style="padding-left: 35%; padding-top: 25px;">
                            <label>Email Greeting</label>
                            <input style="color: black" type="text" name="greeting" id="greeting">
                        </div>

                        <div style="padding-left: 35%; padding-top: 25px;">
                            <label>Email FirstLine </label>
                            <input style="color: black" type="text" name="firstline" id="firstline">
                        </div>

                        <div style="padding-left: 35%; padding-top: 25px;">
                            <label>Email Body :</label>
                            <input style="color: black" type="text" name="body" id="body">
                        </div>

                        <div style="padding-left: 35%; padding-top: 25px;">
                            <label>Email Button :</label>
                            <input style="color: black" type="text" name="button" id="button">
                        </div>

                        <div style="padding-left: 35%; padding-top: 25px;">
                            <label>Email URL :</label>
                            <input style="color: black" type="text" name="url" id="url">
                        </div>

                        <div style="padding-left: 35%; padding-top: 25px;">
                            <label>Email LastLine :</label>
                            <input style="color: black" type="text" name="lastline" id="lastline">
                        </div>

                        <div style="padding-left: 35%; padding-top: 25px;">
                            <input type="submit" value="Send Email" class="btn btn-primary">
                        </div>
                    </form>

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
