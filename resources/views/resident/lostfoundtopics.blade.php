@extends('layoutUser')
@section('index-content')

 <div class="container card mb-3">
      <div class="card-body">
        <div class="float-right" style="margin-bottom: 5%">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add">Add New Post</button>

        </div>

        <div>
          <h1>Lost and Found Board</h1>
        </div>



        <div class="float-left" style="margin-bottom: 2%; margin-top:2%;">


          <form class="form-inline" id="form_search" method="get" action="{{route('search_lostfound')}}">
            {{csrf_field()}}
            <div class="form-group">


              <label class="sr-only" for="inlineFormInputName2">Category</label>
              <select class="form-control  mb-2 mr-sm-2" name="category">
                <option value="2">All</option>
                <option value="0">Lost</option>
                <option value="1">Found</option>
              </select>
            </div>


              <div class="form-group">
                  <label class="sr-only" for="inlineFormInputGroupUsername2">Search</label>
                <div class="input-group mb-2 mr-sm-2">
                  <input type="text" class="form-control"  name="search">
                </div>

            </div>

              <button id="btn_search" type="submit" class="btn btn-primary mb-2">Search</button>
            </form>
        </div>

        <div class="table-responsive">
          @if (count($lostFoundTopics) === 0)
                <p>No Topics Posted</p>
          @else
              @foreach($lostFoundTopics as $one)
                  <div class="card mb-3">
                    <h5 class="card-header"><a  href="{{route('LostFoundReplys', ['id' => $one->id])}}">{{$one->subject}}</a>
                       <div class="float-right">Replys <span class="badge badge-info">{{$one->reply_count}}</span></div></h5>

                    <div class="card-body">

                      <p class="card-text">{{$one->message}}</p>
                      <h6 class="card-title">Posted By: {{$one->email}}<span class="float-right">Date: {{$one->date}}</span></h6>
                      <div class="clearfix">
                      @if ($one->residentId === session()->get('resident_id'))

                            <button class="btn btn-primary btn-detail open-modal float-left" value="{{$one->id}}">Edit</button>

                            <button id="btn_remove" class="btn btn-danger btn-detail float-right" value="{{$one->id}}">Remove</button>
                      @endif
                      </div>
                    </div>
                  </div>
              @endforeach
          @endif

          {{ $lostFoundTopics->appends(Request::except('page'))->links() }}


      </div>
  </div>

  <div class="modal" id="modal_add">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add new Topic</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form id="form_add" method="post" action="{{route('add_topic')}}">
        <div class="modal-body">
            {{csrf_field()}}
            <div class="form-group">
              <label>Category</label>
              <select class="form-control" name="category">
                <option value="0">Lost</option>
                <option value="1">Found</option>
              </select>
            </div>
            <div class="form-group">
              <label>Subject</label>
              <input type="text" class="form-control" name="subject"  placeholder="Lost/Found: ???">
            </div>
            <div class="form-group">
              <label>Message</label>
              <br>
                <textarea class="form-control" style="min-width: 100%" name="message"></textarea>
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





  <div class="modal" id="modal_edit">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Edit package Information</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <form id="form_edit" method="post" action="{{route('edit_topic')}}">


          <div class="modal-body">
              {{csrf_field()}}
              <div class="form-group">
                <input id="edit_id" type="hidden" name="topic_id">
                <input id="edit_resident_id" type="hidden" name="residentId">
                <label>Subject</label>
                <input  id="edit_subject" type="text" class="form-control" name="subject"  placeholder="Lost/Found: ???">
              </div>
              <div class="form-group">
                <label>Message</label>
                <br>
                  <textarea  id="edit_message"class="form-control" style="min-width: 100%" name="message"></textarea>
              </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" id="btn_edit" class="btn btn-primary">Update</button>
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
    $('#ui_lostfound').addClass('active');
  });


  $('.open-modal').click(function(){
    var topic_id = $(this).val();
    console.log(topic_id);
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
      $.ajax({
          type: "GET",
          url: "{{route('get_edit_topic')}}",
          data: {id: topic_id}, // serializes the form's elements.
          success: function(data)
          {

            console.log(data);

             var d = data[0];
             console.log(d);
             $('#edit_id').val(d.id);
             $('#edit_resident_id').val(d.residentId);
             $('#edit_subject').val(d.subject);
             $('#edit_message').val(d.message);

                  $('#modal_edit').modal('show');
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
        alert(data['responseJSON']['message']);
        console.log(data);
      }
    });
});


$(document).on('click','#btn_remove',function(){
  var topic_id = $(this).val();
  console.log(topic_id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    $.ajax({
        type: "GET",
        url: "{{route('remove_topic')}}",
        data: {id: topic_id},
        success: function(data)
        {
          location.reload();
        },
        error: function (data) {

          //console.log(data.responseText);
          console.log(data);
        }
      });

});


$(document).on('click','#btn_edit',function(){
    var form = $('#form_edit');
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
        $('#modal_edit').modal('hide');
        location.reload();
      },
      error: function (data) {
        alert(data['responseJSON']['message']);
        console.log(data);
      }
    });
});

$(document).on('click','#btn_search',function(){
    var form = $('#form_search');
    console.log(form);
    var url = form.attr('action');
    console.log(url);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    console.log(form.serialize());
    $.ajax({
        type: "GET",
        url: url,
        data: form.serialize(),
        success: function(data)
        {

        },
        error: function (data) {
          alert(data['responseJSON']['message']);
            console.log(data);
        }
    });
    });
</script>
@stop
