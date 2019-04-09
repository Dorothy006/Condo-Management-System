@extends('layoutUser')
@section('index-content')

 <div class="container card mb-3">
      <div class="card-body">
        <div class="float-right" style="margin-bottom: 5%">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_create">Create New Message</button>
          <a class="btn btn-warning" href="{{route('MessagesSent')}}" role="button">Sent Messages</a>


        </div>

        <div>
          <h1>Resident-Resident Messaging</h1>
        </div>
        <br>
        <div>
          <h2>Messages Recieved</h2>
        </div>
        <br>
        <div class="table-responsive">

          @if (count($messagesRecieved) === 0)
                <p>No Messages Recieved</p>
          @else

                @foreach($messagesRecieved as $one)
                    @if ($one->read_at === null)
                      <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action open-modal list-group-item-primary"
                        data-target="#modal_read" data-toggle="modal"  href="#modal_read" data-value="{{$one->id}}">
                            Sent By: {{$one->name}} | Subject: {{$one->subject}} | Date: {{$one->created_at}}
                        </a>
                      </div>
                    @else
                    <div class="list-group">
                      <a href="#" class="list-group-item list-group-item-action open-modal"
                      data-target="#modal_read" data-toggle="modal"  href="#modal_read" data-value="{{$one->id}}">
                        Sent By: {{$one->name}} | Subject: {{$one->subject}} | Date: {{$one->created_at}}
                      </a>
                    </div>
                    @endif
                @endforeach
          @endif

      </div>
        <br>
      {{ $messagesRecieved->appends(Request::except('page'))->links() }}
      </div>
  </div>
  <div class="modal" id="modal_create">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Create Message</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form id="form_send" method="post" action="{{route('send_message')}}">
        <div class="modal-body">
            {{csrf_field()}}
            <div class="form-group">
              <label>Send To</label>
              <select class="form-control" name="sentTo">

                @foreach($residents as $resident)
                  <option value="{{$resident->id}}">{{$resident->name}}, Room {{$resident->roomnumber}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Subject</label>
              <input type="text" class="form-control" name="subject" placeholder="Subject">
            </div>
            <div class="form-group">
              <label>Message</label>
              <br>
                <textarea class="form-control" style="min-width: 100%" name="message"></textarea>
            </div>

        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" id="btn_send" class="btn btn-primary">Send</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
        </form>
      </div>
    </div>
  </div>


  <div class="modal" id="modal_read" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Message</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->



          <div class="modal-body">

              <div class="form-group">
                <label>From</label>
                <input  id="read_sender" type="text" class="form-control" name="sender"  readonly>
                </div>
                <div class="form-group">
                <label>Subject</label>
                <input  id="read_subject" type="text" class="form-control" name="subject"  readonly>
              </div>
              <div class="form-group">
                <label>Message</label>
                <br>
                  <textarea  id="read_message"class="form-control" style="min-width: 100%" name="message" readonly></textarea>
              </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#ui_message').addClass('active');
    $('#modal_read').on('hide.bs.modal', function () {
    //  console.log("YESSSS");

     location.reload();
     $('#read_sender').val("");
     $('#read_subject').val("");
     $('#read_message').val("");
   });
  });


  $('.open-modal').click(function(){
    var mid = $(this).data("value")
    console.log(mid);
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
      $.ajax({
          type: "GET",
          url: "{{route('read_message')}}",
          data: {id: mid}, // serializes the form's elements.
          success: function(data)
          {

            console.log(data);

             var d = data[0];
             console.log(d);
             $('#read_sender').val(d.name);
             $('#read_subject').val(d.subject);
             $('#read_message').val(d.body);

            $('#modal_read').modal('show');
          },
          error: function (data) {

            //console.log(data.responseText);
            console.log(data);
          }
        });

  });



  $(document).on('click','#btn_send',function(){
      var form = $('#form_send');
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
          $('#modal_create').modal('hide');
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
