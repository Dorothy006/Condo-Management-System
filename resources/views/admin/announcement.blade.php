@extends('layout')
@section('index-content')
 <div class="container card mb-3">
      <div class="card-body">
        <div class="float-right" style="margin-bottom: 5%">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add">Add</button>
          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_update">Update</button>
          <button type="button" class="btn btn-danger" id="btn_modal_remove">Remove</button>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th></th>
                <th>Announcement Description</th>
                <th>Time</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @foreach($announcement as $one)
              <tr>
                <td><input id="announcement_{{$one->id}}" type="checkbox" class="form-control" name="announcement[]" value="{{$one->id}}"></td>
                <td>{{$one->announce_desc}}</td>
                <td>{{$one->time}}</td>
                <td>{{$one->date}}</td>
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
          <h4 class="modal-title">Adding new announcement</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form id="form_add" method="post" action="{{route('add_announcement')}}">
        <div class="modal-body">
            {{csrf_field()}}
            <div class="form-group">
              <label>Announcement Description</label>
              <input type="text" class="form-control" name="announce_desc"  placeholder="Description">
            </div>
            <div class="form-group">
              <label>Time</label>
              <input type="time" class="form-control" name="time" placeholder="Enter time">
            </div>
            <div class="form-group">
              <label>Date</label>
              <input type="date" class="form-control" name="date" placeholder="Enter date">
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
        <form id="form_update" method="post" action="{{route('update_announcement')}}">
        <div class="modal-body">
            {{csrf_field()}}
            <div class="form-group">
              <label>Select a announcement to update</label>
              <select id="update_id" name="id" placeholder="Select a announcement" style="width: 300px;">
                  <option value=""></option>

                @foreach($announcement as $one)
                  <option value="{{$one->id}}">{{$one->announce_desc}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Announcement Description</label>
              <input id="update_desc" type="text" class="form-control" name="announce_desc" placeholder="Enter description">
            </div>
            <div class="form-group">
              <label>Time</label>
              <input id="update_time" type="time" class="form-control" name="time" placeholder="Enter time">
            </div>
            <div class="form-group">
              <label>Date</label>
                <input id="update_date" type="date" class="form-control" name="date" placeholder="Enter date">
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
    <div class="modal" id="modal_delete">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Are you sure to delete these announcements?</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form id="form_delete" method="post" action="{{route('delete_announcement')}}">
          <input type="text" id="remove_list" name="remove_list" hidden>
        </form>
        <div class="modal-footer">          
          <button type="button"  data-dismiss="modal" class="btn btn-primary">Close</button>
          <button type="button" id="btn_delete" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </div>
  </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>


  <script type="text/javascript">
  $(document).ready(function(){
    $('#li_announcement').addClass('active');
    $("#update_id").select2();
  });
  $('#update_id').on('change', function (e) {

});
  $('#update_id').on('select2:select',function(){
    alert('123123');


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

          $('#modal_add').modal('hide');
            alert(data);
          location.reload();
        },
        error: function (data) {
          alert(data);
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
          alert(data);
          $('#modal_update').modal('hide');
          location.reload();
        },
        error: function (data) {
          alert('error');
          console.log(data);
        }
      });
  });   
  $(document).on('click','#btn_modal_remove',function(){
    var arr=[];
    if($('input[name="announcement[]"]:checked').length>0){
      $('input[name="announcement[]"]:checked').each(function(){
        arr.push($(this).val());
      });
      $('#remove_list').val(arr);
      $('#modal_delete').modal('toggle');
    }else{
      snackbar('Select at least one announcement to remove.');
    }
  });
  $(document).on('click','#btn_delete',function(){

      var form = $('#form_delete');
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
          snackbar(data);
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