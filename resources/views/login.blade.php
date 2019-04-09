<!DOCTYPE html>
<html lang="en">

  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

  </head>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">
           <form id="form_login" method="post" action="{{route('login')}}">
            {{csrf_field()}}
            <!-- {!! Form::open(['route'=>['login'],'method'=>'post']) !!} -->
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="account" name="account" class="form-control" placeholder="Account" required="required" autofocus="autofocus">
                <label for="account">Account</label>
                <!-- {{Form::label('account','Account')}}
                {{Form::text('account',null,['class'=>'form-control','placeholder'=>'Account','required'=>'required','autofocus'=>'autofocus'])}} -->
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="required">
                <label for="password">Password</label> 
                <!-- {{Form::label('password','Password')}}
                {{Form::text('password',null,['class'=>'form-control','placeholder'=>'Password','required'=>'required'])}} -->
              </div>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="remember-me">
                  <!-- {{Form::checkbox('remember','remember')}} -->
                  Remember Password
                </label>
              </div>
            </div>
            <!-- {{Form::submit('Login',null,['class'=>'btn btn-primary btn-block'])}} -->
            <button type="button" class="btn btn-primary btn-block" id="btn_login">Login</button>
            <!-- {!! Form::close() !!} -->
          </form>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  </body>

</html>
<script type="text/javascript">
  $(document).ready(function(){
    // window.location.href="{{route('console')}}"
  });
  $('#btn_login').on('click',function(){
    var form = $('#form_login');
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
      data: form.serialize(), // serializes the form's elements.
      success: function(data)
      {
        
        if(data=="success")
          window.location.replace("{{route('console')}}");
        else if(data=="wrong")
          alert("wrong");
        else
          alert("no user");
      },
      error: function (data) {
        alert('error');
        console.log(data);
      }
    });
  });

</script>