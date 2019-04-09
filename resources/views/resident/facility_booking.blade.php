@extends('layoutUser')
@section('index-content')
 <div class="container card mb-3">
      <div class="card-body">
        <div class="float-right" style="margin-bottom: 5%">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add">Add</button>
          <button type="button" class="btn btn-danger" id="btn_modal_remove">Remove</button>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                  <th></th>
                  <th>Room Number</th>
                  <th>Facility Name</th>
                  <th>Duration</th>
                  <th>Fee</th>
                  <th>Date</th>
                  <th>Time In</th>
                  <th>Time Out</th>
              </tr>
            </thead>
            <tbody>
              @foreach($facility_booking as $one)
              <tr>
                  <td><input id="facility_booking_{{$one->id}}" type="checkbox" class="form-control" name="facility_booking[]" value="{{$one->id}}"></td>
                  <td>{{$one->roomNumber}}</td>
                  <td>{{$one->facility_name}}</td>
                  <td>{{$one->duration}} hour</td>
                  <td>${{$one->fee}}</td>
                  <td>{{$one->booking_date}}</td>
                  <td>{{$one->time_in}}</td>
                  <td>{{$one->time_out}}</td>
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
          <h4 class="modal-title">Adding A New Facility Booking</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form id="form_add" method="post" action="{{route('add_facility_booking')}}">
        <div class="modal-body">
            {{csrf_field()}}
            <div class="form-group">
                <label>Room Number: </label>
                <label name="roomNumber" placeholder="Select a room number">
                    @foreach($rooms as $one)
                        <label value="{{$one->roomNumber}}">{{$one->roomnumber}}</label>
                    @endforeach
                </label>
            </div>
            <div class="form-group">
              <label>Facility Name</label>
                <select name="facility_name" placeholder="Select a facility" style="width: 300px;">
                    <option value=""></option>
                    @foreach($facilities as $one)
                        <option value="{{$one->facility_name}}">{{$one->facility_name}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <div class="form-group">
                    <label>Booking Date</label>
                    <input type="date" id="sel_date" class="form-control" name="booking_date" placeholder="Select a date">
                </div>
            </div>
            <div class="form-group">
                <label>Time In</label>
                <input type="time" class="form-control" name="time_in" placeholder="Enter time in">
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
        
    {{--delete a facility booking--}}
    <div class="modal" id="modal_delete">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Are you sure to delete this facility_bookings?</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form id="form_delete" method="post" action="{{route('delete_facility_booking')}}">
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
    $('#li_facility_booking').addClass('active');
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
          console.log(data.responseText);
        }
      });
  });
  $(document).on('click','#btn_modal_remove',function(){
    var arr=[];
    if($('input[name="facility_booking[]"]:checked').length>0){
      $('input[name="facility_booking[]"]:checked').each(function(){
        arr.push($(this).val());
      });
      $('#remove_list').val(arr);
      $('#modal_delete').modal('toggle');
    }else{
      alert('Select at least one facility booking to remove.');
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
            alert(data);
            $('#modal_delete').modal('hide');
            location.reload();
        },
        error: function (data) {
            alert(data);
            console.log(data.responseText);
            console.log(data);
        }
      });
  });   
</script>
@stop