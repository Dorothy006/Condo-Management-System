@extends('layout')
@section('index-content')
    <link href="css/dorothy.css" rel="stylesheet">
    <div class="card-body">
        <div class="welcomeHeader">
            <h2>Welcome! Please Log In Here.</h2>
        </div>
        <div class="row">
            <div class="col-md-5" id="visitorImg">
                <img src="images/signup-image.jpg" alt="sing up image" style="float: right">
            </div>
            <div class="col-md-5">
                <form method="POST" class="visitorLogIn" id="visitor_LogIn" action="{{route('visitorLoginSubmit')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Your Name">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Your Email">
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" class="form-control" placeholder="Your Phone">
                    </div>
                    <div class="form-group">
                        <select id="roomid" name="roomid" class="form-control">
                            <option value="please select "  >Please Select Room Number</option>
                            @foreach($rooms as $room)
                                <option value="{{$room->id}}">{{$room->roomnumber}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="agree-term" id="agree-term" class="agree-term">
                        <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                    </div>
                    <div class="form-group">
                        <button type="button" id="btn_visitor_login" class="btn btn-info" id="visitorLogIn">Log In</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#ui_visitor_logIn').addClass('active');
        });
        $(document).on('click','#btn_visitor_login',function(){
            var form = $('#visitor_LogIn');
            var url = form.attr('action');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            console.log(form.serialize());
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(data)
                {
                    alert('Message was sent, waiting for confirming');
                },
                error: function (data) {
                    alert('error');
                    console.log(data);
                }
            });
        });

    </script>

@stop