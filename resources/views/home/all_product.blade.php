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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="hero_area">
        <!-- Header section -->
        @include('home.header')
        <!-- End Header section -->

        <!-- product section -->
        @include('home.product_view')
        <!-- end product section -->
    </div>

    {{-- Comment and Reply System --}}

    <div style="text-align: center; padding-bottom: 30px;">
        <h1 style="font-size: 30px; text-align: center; padding-bottom: 20px;padding-top: 20px;">Comments</h1>

        <form action="{{ url('add_comment') }}" method="POST">
            @csrf
            <textarea style="height: 250px; width: 600px" name="comment" id="comment" placeholder="Comment Something Here"></textarea>

            <br />
            <input type="submit" class="btn btn-primary" value="Add Coment">
        </form>
    </div>

    <div style="padding-left: 10%; padding-bottom: 20px;">
        <h1 style="font-size: 30px; padding-top: 20px;">All Comments</h1>

        @foreach ($comments as $comment)
            <div>
                <b>{{ $comment->name }}</b>
                <p>{{ $comment->comment }}</p>

                <a style="color: blue" href="javascript::void(0);" onclick="reply(this)"
                    data-Commentid="{{ $comment->id }}">Reply</a>
            </div>

            <div style="padding-left: 3%; padding-bottom: 10px;">
                @foreach ($replys as $reply)
                    @if ($reply->comment_id == $comment->id)
                        <b>{{ $reply->name }}</b>
                        <p>{{ $reply->reply }}</p>
                        <a style="color: blue" href="javascript::void(0);" onclick="reply(this)"
                            data-Commentid="{{ $comment->id }}">Reply</a>
                        <br />
                    @endif
                @endforeach
            </div>
        @endforeach

        <div style="display: none; padding-top: 20px;" class="replyDiv">
            <p>Write new Reply</p>
            <form action="{{ url('add_reply') }}" method="POST">
                @csrf
                <input type="text" name="commentId" id="commentId" hidden>
                <textarea style="height: 100px; width: 400px" name="reply" id="reply" placeholder="Write Something Here"></textarea>

                <br />
                <button type="submit" class="btn btn-warning">Reply</button>
                <a href="javascript::void(0)" class="btn" onclick="reply_close(this)">Close</a>
            </form>
        </div>
    </div>


    {{-- End Of Comment and Reply System --}}

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

    <script type="text/javascript">
        function reply(caller) {
            document.getElementById('commentId').value = $(caller).attr('data-Commentid');

            $('.replyDiv').insertAfter($(caller));

            $('.replyDiv').show();
        }

        function reply_close(caller) {
            $('.replyDiv').hide();
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>
</body>

</html>
