Email id valid, Welcome to C4I System<br><a href="{{route('register',["id"=>$resident->id,"token"=>$resident->token])}}">Click here to login</a><br>
Your default account is your email, and tempory password is {{$resident->token}}.
<br>Please cnange your password once you login into our system. <br>Thank you
