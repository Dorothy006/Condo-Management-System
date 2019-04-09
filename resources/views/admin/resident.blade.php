@extends('layout')
@section('index-content')

 <div class="container card mb-3">
      <div class="card-body">
        <div class="float-right" style="margin-bottom: 5%">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add">Add</button>
          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_update">Update</button>
          <button type="button" class="btn btn-danger" id="btn_remove">Remove</button>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th></th>
                <th>Name</th>
                <th>Room Number</th>
                <th>Phone</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Account</th>
              </tr>
            </thead>
            <tbody id="resident_table">
              @foreach($residents as $one)
              <tr>
                <td><input id="resident_{{$one->id}}" type="checkbox" name="{{$one->id}}"/></td>
                <td>{{$one->name}}</td>
                <td>{{$one->roomid}}</td>
                <td>{{$one->phone}}</td>
                <td>{{$one->mobile}}</td>
                <td>{{$one->email}}</td>
                @if($one->isaccess==-1)
                <td><span class="btn-primary rounded">Activity!</span></td>
                @elseif($one->isaccess==1)
                <td> 
                  <a class="nounderline" href="javascript:reemail(2,{{$one->id}})"><span class="btn-warning rounded">Re-send</span></a>
                </td>
                @else
                <td>
                  <a class="nounderline" href="javascript:email(1,{{$one->id}})"><span class="btn-danger rounded">Verify</span></a>
                </td>
                @endif
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
  </div>
  <div class="modal" id="modal_add">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="">Adding new resident</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form id="form_add" method="post" action="{{route('add_resident')}}">
        <div class="modal-body">
            {{csrf_field()}}
            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" name="name"  placeholder="Name">
            </div>
            <div class="form-group">
              <label>Email address</label>
              <input type="email" class="form-control" name="email" placeholder="Enter email">
            </div>
            <div class="form-group">
              <label>Room Id</label>
              <select id="roomid" name="roomid">
                  <option value=""></option>
                @foreach($rooms as $room)
                  <option value="{{$room->id}}">{{$room->roomnumber}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Moblie</label>
              <input type="number" class="form-control" name="mobile" placeholder="Mobile">
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input type="number" class="form-control" name="phone" placeholder="Phone">
            </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" id="btn_add" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<div class="modal" id="modal_update">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 id="update_title" class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form id="form_update" method="post" action="{{route('update_resident')}}">
        <div class="modal-body">
            {{csrf_field()}}
            <div class="form-group">
              <label>Select a resident to update</label>
              <select id="update_id" name="id" placeholder="Select a resident">
                  <option value=""></option>

                @foreach($residents as $one)
                  <option value="{{$one->id}}">{{$one->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Name</label>
              <input id="update_name" type="text" class="form-control" name="name" placeholder="Enter name">
            </div>
            <div class="form-group">
              <label>Email address</label>
              <input id="update_email" type="email" class="form-control" name="email" placeholder="Enter email">
            </div>
            <div class="form-group">
              <label>Room Number</label>
              <select id="roomid" name="roomid">
                  <option value=""></option>
                @foreach($rooms as $room)
                  <option value="{{$room->id}}">{{$room->roomnumber}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Moblie</label>
              <input id="update_mobile" type="number" class="form-control" name="mobile" placeholder="Mobile">
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input id="update_phone" type="number" class="form-control" name="phone" placeholder="Phone">
            </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" id="btn_update" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal" id="modal_remove">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 id="update_title" class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <p class="form-control" id="label_remove"></p>
        <form id="form_remove" action="{{route('delete_resident')}}" method="GET">
          <input id="remove_list" type="text" name="remove_list" value="" hidden/>
        </form>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" id="btn_delete" class="btn btn-primary">Remove</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>


  <script type="text/javascript">
  function email(type,uid){
    if(type==2){

    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    $.ajax({
        type: "GET",
        url: "{{route('verifymail')}}",
        data: {id: uid}, // serializes the form's elements.
        success: function(data)
        {
          
          location.reload();
        },
        error: function (data) {
          
          console.log(data.responseText);
          console.log(data);
        }
      });
  }
  $(document).ready(function(){
    $('#li_resident').addClass('active');
    // $("#update_id").select2();
  });
  $(document).on('change','#update_id',function(){
    <?php foreach ($residents as $resident): ?>
      if({{$resident->id}}==$('#update_id').val()){
        $('#update_name').val('{{$resident->name}}');
        $('#update_email').val('{{$resident->email}}');
        $('#update_phone').val('{{$resident->phone}}');
        $('#update_mobile').val('{{$resident->mobile}}');
        $('#update_room').val('{{$resident->roomid}}');
      }      
    <?php endforeach ?>
    
  });
  $(document).on('click','#btn_add',function(){
      var form = $('#form_add');
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
          if(data!="exist"){
            $('#modal_add').modal('hide');
            location.reload();
          }else
          alert("This email is already used");
        },
        error: function (data) {
          alert('error');
          console.log(data);
        }
      });
  });
  $(document).on('click','#btn_update',function(){
      var form = $('#form_update');
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
          $('#modal_update').modal('hide');
          location.reload();
        },
        error: function (data) {
          alert('error');
          console.log(data);
        }
      });
  });
  var selected = [];
  $(document).on('click','#btn_remove',function(){
    selected = [];
    $('#resident_table input:checked').each(function() {
        selected.push($(this).attr('name'));
    });
    if(selected.length > 0){
      $('#label_remove').html("Are you sure to remove these "+selected.length+" residents from the list?");
      $('#remove_list').val(selected);
      $('#modal_remove').modal('show'); 
    }else{
        snackbar("Please select at least one resident to remove.");
    }

  });
  $(document).on('click','#btn_delete',function(){

      var form = $('#form_remove');
      var url = form.attr('action');
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      console.log(form.serialize());
      $.ajax({
        type: "GET",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {
          location.reload();
          // if(data==""){
          //   $('#modal_delete').modal('hide');
          //   location.reload();
          // }else alerrt(data);
        },
        error: function (data) {
          
          console.log(data.responseText);
          console.log(data);
        }
      });
  });   
</script>
@stop
