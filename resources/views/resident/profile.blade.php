@extends('layoutUser')
@section('index-content')
<header>
<meta name="csrf-token" content="{{ csrf_token() }}">


  <style type="text/css">
    @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,700,300);
body {
    font: 12px 'Open Sans';
}
.form-control, .thumbnail {
    border-radius: 2px;
}
.btn-danger {
    background-color: #B73333;
}

/* File Upload */
.fake-shadow {
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}
.fileUpload {
    position: relative;
    overflow: hidden;
}
.fileUpload #logo-id {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 33px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
.img-preview {
    max-width: 100%;
}
  </style>
</header>
 <div class="container" class="col-md-4 col-md-offset-2">
  <form id="myform" action="{{route('profile_update')}}" method="POST" enctype="multipart/form-data">
    <input type="hidden" value="{{ csrf_token() }}" name="_token">
    <div class="row">
    
      <div style="width:100%;">
          <div class="form-group" style="margin-left:30%;"   >
              <div class="main-img-preview">
                @if($resident->photo !='')
                <img height="50%" width="40%" id="preview" class="thumbnail img-preview" src="{{asset('images/'.$resident->photo)}}" title="Preview Logo">
                @else                
                <img height="50%" width="40%" id="preview" class="thumbnail img-preview" src="{{asset('images/default-user.jpg')}}" title="Preview Logo">
                @endif
              </div>
              <div class="fileUpload btn btn-danger">
                <input id="photo" name="photo" type="file">
              </div>
          </div>
      </div>
    </div>

    <button id="save" class="btn btn-primary" type="button" style="margin-left: 40%">Save Change</button>
    <div class="row">
      <div style="width: 100%;">
         <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="text-align: center;">
              <tr>
                <td>Name</td>
                <input type="text" name="name" id="iname" value="{{$resident->name}}" hidden/>
                <td id="name"><a id="aname" href="javascript:clicka(0)">{{$resident->name}}</a></td>
              </tr>
              <tr>
                <td>Email</td>
                <input type="text" name="email" id="iemail" value="{{$resident->email}}" hidden/>
                <td id="email"><a id="aemail" href="javascript:clicka(1)">{{$resident->email}}</a></td>
              </tr>
              <tr>
                <td>Password</td>
                <input type="text" name="password" id="ipass" value="{{$resident->token}}" hidden/>
                <td id="pass"><a id="apass" href="javascript:clicka(2)">{{$resident->token}}</a></td>
              </tr>
              <tr>
                <td>Phone</td>
                <input type="text" name="phone" id="iphone" value="{{$resident->phone}}" hidden/>
                <td id="phone"><a id="aphone" href="javascript:clicka(3)">
                  @if($resident->phone=='')
                  empty
                  @else
                  {{$resident->phone}}
                  @endif
                </a></td>
              </tr>
              <tr>
                <td>Mobile</td>
                <input type="text" name="mobile" id="imobile" value="{{$resident->mobile}}" hidden/>
                <td id="mobile"><a id="amobile" href="javascript:clicka(4)">
                  @if($resident->mobile=='')
                  empty
                  @else
                  {{$resident->mobile}}
                  @endif
                </a></td>
              </tr>
              <tr>
                <td>Room</td>
                <td>{{$resident->roomnumber}}</td>
              </tr>
            </table>

          </div>
      </div>
    </div>     
  </form>

</div>
<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script> 

<script type="text/javascript">
  $(document).ready(function() {
    $('#save').hide();
  });
  function change(i){
    if(i==0){
      var name=$('#name_input').val();
      $('#iname').val(name);
      $('#name').html("<a id='aname' href='javascript:clicka(0)'>"+name+"</a>");
    }else if(i==1){
      var email=$('#email_input').val();
      $('#iemail').val(email);
      $('#email').html("<a id='aemail' href='javascript:clicka(1)'>"+email+"</a>");
    }else if(i==2){
      var password=$('#password_input').val();
      $('#ipass').val(password);
      $('#pass').html("<a id='apass' href='javascript:clicka(2)'>"+password+"</a>");
    }else if(i==3){
      var phone=$('#phone_input').val();
      $('#iphone').val(phone);
      $('#phone').html("<a id='aphone' href='javascript:clicka(3)'>"+phone+"</a>");
    }else if(i==4){
      var mobile=$('#mobile_input').val();
      $('#imobile').val(mobile);
      $('#mobile').html("<a id='amobile' href='javascript:clicka(4)'>"+mobile+"</a>");
    }

    saveChange();
  }
  function cancel(i){
    if(i==0){
      $('#iname').val('{{$resident->name}}');
      $('#name').html("<a href='javascript:clicka(0)'>{{$resident->name}}</a>");
    }
    else if(i==1){
      $('#iemail').val('{{$resident->email}}');
      $('#email').html("<a href='javascript:clicka(1)'>{{$resident->email}}</a>");
    }
    else if(i==2){
      $('#ipass').val('{{$resident->token}}');
      $('#pass').html("<a href='javascript:clicka(2)'>{{$resident->token}}</a>");
    }
    else if(i==3){
      $('#iphone').val('{{$resident->phone}}');
      $('#phone').html("<a href='javascript:clicka(3)'>{{$resident->phone}}</a>");      
    }
    else if(i==4){
      $('#imobile').val('{{$resident->mobile}}');
      $('#mobile').html("<a href='javascript:clicka(4)'>{{$resident->mobile}}</a>");
    }
  }
  function clicka(i){
    var btn="<button style='margin-left:5px' onclick='change("+i+")' type='button' class='btn btn-primary'>Save</button><button style='margin-left:5px' type='button' class='btn btn-danger' onclick='cancel("+i+")'>Cancel</button>";
    if(i==0){
      $('#name').html("<input id='name_input' type='text'/>"+btn);
    }else if(i==1){
      $('#email').html("<input id='email_input' type='text'/>"+btn);
    }else if(i==2){
      $('#pass').html("<input id='password_input' type='text'/>"+btn);
    }else if(i==3){
      $('#phone').html("<input id='phone_input' type='text'/>"+btn);
    }else if(i==4){
      $('#mobile').html("<input id='mobile_input' type='text'/>"+btn);
    }

  }
  function saveChange(){
    $('#save').show();
    $('#save').on('click',function(){
      
      $('#myform').submit();
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });
      // data = new FormData();
      // data.append(file.name, file);

      // alert(JSON.stringify(formData));
      // $.ajax({
      //   type: "POST",
      //   url: "{{route('profile_update')}}",
      //   data: formData, // serializes the form's elements.
      //   success: function(data)
      //   {
      //     location.reload();
      //   },
      //   error: function (data) {
          
      //     console.log(data.responseText);
      //     console.log(data);
      //   }
      // });
    });
    
  }
  $('#photo').on('change',function(){
    saveChange();
    var files = !!this.files ? this.files : [];
    var reader = new FileReader(); 
    reader.readAsDataURL(files[0]);
    reader.onloadend = function(){ 
      $('#preview').attr('src',this.result);
    }
  });

</script>
@stop
