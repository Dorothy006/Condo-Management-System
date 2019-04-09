@extends('layout')
@section('index-content')

 <div class="container card mb-3">
      <div class="card-body">
        <div class="float-right" style="margin-bottom: 5%">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add">Add New Package</button>

        </div>
        <div>
          <h2>Package Manager</h2>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Room Number</th>
                <th>Package Delivered</th>
                <th>Name on Package</th>
                <th>Mailbox</th>
                <th>Mailbox Password</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($packages as $one)
              <tr>
                <td>{{$one->roomnumber}}</td>
                <td>{{$one->date}}</td>
                <td>{{$one->packageName}}</td>
                <td>{{$one->mailboxId}}</td>
                <td>{{$one->mailboxPW}}</td>
                @if ($one->status === 1)
                      <td style="color:red;">Unconfirmed</td>
                @else
                      <td style="color:green;">Confirmed Recieved</td>
                @endif
                <td>
                     <form action="{{route('remove_package')}}" method="post"
                           id="remove_form">

                         <input type="hidden" name="package_id"
                                value="{{$one->id}}">
                         <input type="hidden" name="mailbox_id"
                                value="{{$one->mailboxId}}">
                                {{csrf_field()}}
                                  <button type="button"  id="btn_remove" class="btn btn-danger">Remove</button>

                     </form>
                 </td>
                 <td>
                    <button class="btn btn-warning btn-xs btn-detail open-modal" value="{{$one->id}}">Edit</button>
                  </td>
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
          <h4 class="modal-title">Adding new Package</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form id="form_add" method="post" action="{{route('add_package')}}">
        <div class="modal-body">
            {{csrf_field()}}
            <div class="form-group">
              <label>Room Number</label>
              <select class="form-control" name="roomId">
                <!--     <option value="Select Room"></option> -->

                @foreach($rooms as $room)
                  <option value="{{$room->id}}">{{$room->roomnumber}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Name on Package</label>
              <input type="text" class="form-control" name="packageName" placeholder="Name on Package">
            </div>
            <div class="form-group">
              <label>Additional Package Information</label>
              <input type="text" class="form-control" name="packageInfo" placeholder="Package Info">
            </div>
            <div class="form-group">
              <label>Mailbox</label>
              <select class="form-control" name="mailbox" >
              <!--  <option value="Select Avaliable Mailbox"></option> -->
                @foreach($mailbox as $mbox)
                  <option  value="{{$mbox->id}}">{{$mbox->id}}</option>
                @endforeach
              </select>
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
            <h4 class="modal-title">Edit package Information</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <form id="form_update" method="post" action="{{route('update_package')}}">
          <div class="modal-body">
              {{csrf_field()}}

              <input id="update_id" type="hidden" name="package_id">
              <div class="form-group">
                <label>Room Number</label>
                <select class="form-control" id="update_roomId" name="roomId">

                  @foreach($rooms as $room)
                    <option value="{{$room->id}}">{{$room->roomnumber}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Name on Package</label>
                <input id="update_packName" type="text" class="form-control" name="packageName" >
              </div>
              <div class="form-group">
                <label>Additional Package Information</label>
                <input id="update_packInfo" type="text" class="form-control" name="packageInfo" placeholder="Package Info">
              </div>
              <div class="form-group">
                <input id="mailbox_id_old" type="hidden" name="mailbox_id_old">
                <label>Mailbox</label>
                <select class="form-control" id="update_mailbox" name="mailbox" >
                </select>

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

  <script type="text/javascript">
  $(document).ready(function(){
      $('#li_package').addClass('active');
  });


/*
  $('.open-modal').click(function(){
     $('#update_mailbox').find('option').remove().end();
      var pack_id = $(this).val();
      var url = '/php-group-project-c4i/public/package';
      $.get(url + '/' + pack_id, function (data) {
          //success data
    console.log(data);

     var d = data[0];
     console.log(d);
     $('#update_id').val(d.id);
     $('#update_roomId').val(d.roomId);
     $('#update_packName').val(d.packageName);
     $('#update_packInfo').val(d.packageInfo);
     var pro = "";
     $("#update_mailbox").html(pro);
     $("#update_mailbox").prepend("<option value='"+d.mailboxId+ "' selected='selected'>"+d.mailboxId+"</option>");

     $('#mailbox_id_old').val(d.mailboxId);
     $('#update_mailbox').val(d.mailboxId);
     $('#updatePW').val(d.mailboxPW);
     $('#update_date').val(d.date);

          $('#modal_update').modal('show');
      })
  });
*/

  $('.open-modal').click(function(){
    $('#update_mailbox').find('option').remove().end();
     var pack_id = $(this).val();
    console.log(pack_id);
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
      $.ajax({
          type: "GET",
          url: "{{route('get_update_package')}}",
          data: {id: pack_id}, // serializes the form's elements.
          success: function(data)
          {

            console.log(data);

             var d = data[0];
             console.log(d);
             $('#update_id').val(d.id);
             $('#update_roomId').val(d.roomId);
             $('#update_packName').val(d.packageName);
             $('#update_packInfo').val(d.packageInfo);
             var pro = "";
             <?php foreach ($mailbox as $mbox): ?>
                     pro += "<option value='" + {{$mbox->id}} +  "'>"  + {{$mbox->id}} +  "</option>";
             <?php endforeach ?>
             $("#update_mailbox").html(pro);
             $("#update_mailbox").prepend("<option value='"+d.mailboxId+ "' selected='selected'>"+d.mailboxId+"</option>");

             $('#mailbox_id_old').val(d.mailboxId);
             $('#update_mailbox').val(d.mailboxId);
             $('#updatePW').val(d.mailboxPW);
             $('#update_date').val(d.date);

                  $('#modal_update').modal('show');
          },
          error: function (data) {

            //console.log(data.responseText);
            console.log(data);
          }
        });

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
            location.reload();
          },
          error: function (data) {
            console.log(data['responseJSON']['message']);
            alert(data['responseJSON']['message']);
            console.log(data);
          }
        });
    });

    $(document).on('click','#btn_remove',function(){
        var form = $('#remove_form');
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
            alert(data['responseJSON']['message']);
            console.log(data);
          }
        });
    });
</script>
@stop
