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
                <th>Id</th>
                <th>Room Number</th>
                <th>Size</th>
                <th>Residents</th>
              </tr>
            </thead>
            <tbody id="table_list">
              @foreach($rooms as $room)
              <tr>
                <td><input id="  " type="checkbox" class="form-control" name="{{$room->id}}"></td>
                <td>{{$room->id}}</td>
                <td>{{$room->roomnumber}}</td>
                <td>{{$room->size}} &#13217;</td>
                <td>{{$room->residents}}</td>
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
          <h4 class="modal-title">Adding new room</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form id="form_add" method="post" action="{{route('add_room')}}">
        <div class="modal-body">
            {{csrf_field()}}
            <div class="form-group">
              <label>Room number</label>
              <input type="text" class="form-control" name="roomnumber"  placeholder="Room number">
            </div>
            <div class="form-group">
              <label>Square meter</label>
              <input type="number" class="form-control" name="size" placeholder="Square meter">
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
          <h4 class="modal-title">update a room</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form id="form_update" method="post" action="{{route('update_room')}}">
        <div class="modal-body">
            {{csrf_field()}}
            <div class="form-group">
              <label>Select a resident to update</label>
              <select id="update_id" name="id" placeholder="Select a resident">
                  <option value=""></option>

                @foreach($rooms as $one)
                  <option value="{{$one->id}}">{{$one->roomnumber}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Room number</label>
              <input id="update_number" type="text" class="form-control" name="roomnumber"  placeholder="Room number">
            </div>
            <div class="form-group">
              <label>Square meter</label>
              <input id="update_size" type="number" class="form-control" name="size" placeholder="Square meter">
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
        <form id="form_remove" action="{{route('delete_room')}}" method="GET">
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
  $(document).ready(function(){
    $('#li_rooms').addClass('active'); 
    // $("#update_id").select2();
  });
  $(document).on('change','#update_id',function(){
    <?php foreach ($rooms as $one): ?>
      if({{$one->id}}==$('#update_id').val()){
        $('#update_number').val('{{$one->roomnumber}}');
        $('#update_size').val('{{$one->size}}');
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
      $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {
          $('#modal_add').modal('hide');
          location.reload();
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
    $('#table_list input:checked').each(function() {
        selected.push($(this).attr('name'));
    });
    if(selected.length > 0){
      $('#label_remove').html("Are you sure to remove these "+selected.length+" rooms from the list?");
      $('#remove_list').val(selected);
      $('#modal_remove').modal('show'); 
    }else{
        snackbar("Please select at least one room to remove.");
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
          $('#modal_delete').modal('hide');
          location.reload();
        },
        error: function (data) {
          
          console.log(data.responseText);
          console.log(data);
        }
      });
  });   
</script>
@stop