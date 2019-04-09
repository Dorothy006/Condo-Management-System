@extends('layoutUser')
@section('index-content')

<div class="container card mb-3">
     <div class="card-body">
       <div class="float-right" style="margin-bottom: 5%">
         <a class="btn btn-info" href="{{route('LostFoundTopics')}}" role="button">Back</a>
       </div>


         @foreach($topic as $t)
          <h2>{{$t->subject}}</h2>
          <h4>{{$t->message}}</h4>
          <h6>Posted By: {{$t->email}}<span class="float-right">Date: {{$t->date}}</span></h6>
         @endforeach
         <hr>
       <div class="table-responsive">

             @foreach($lostFoundReplies as $one)
             <div class="card mb-3">
             <div class="card-body">
               <p class="card-text">{{$one->message}}</p>
               <h6 class="card-title">Reply By: {{$one->email}}</h6>
               <p class="card-text">{{$one->date}}</p>
               @if ($one->residentId === session()->get('resident_id'))

               <div class="clearfix">

               <button class="btn btn-info btn-xs btn-detail open-modal float-left" data-value="{{$one->topicId}}" value="{{$one->id}}">Edit</button>

               <button  id="btn_remove" class="btn btn-xs btn-danger float-right" data-value="{{$one->topicId}}" value="{{$one->id}}">Remove</button>
             </div>
               @endif
             </div>
           </div>
             @endforeach

       </div>
       {{ $lostFoundReplies->appends(Request::except('page'))->links() }}

       <div class="table-responsive" style="margin-top:100px;">
             <div class="card mb-3">
               <h5 class="card-header">Add a Reply</h5>
             <div class="card-body">
               <form id="form_reply" method="post" action="{{route('reply', ['id' => $id])}}">
               <div class="modal-body">
                   {{csrf_field()}}

                   <input type="hidden" name="topicId"  value="{{$id}}">

                   <div class="form-group">
                       <textarea class="form-control" style="min-width: 100%" name="message"></textarea>
                   </div>

               </div>
               <!-- Modal footer -->

                 <button type="button" id="btn_reply" class="btn btn-info">Reply</button>

               </form>
             </div>
           </div>
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
         <form id="form_edit" method="post" action="{{route('edit_reply', ['id' => $id])}}">
         <div class="modal-body">
             {{csrf_field()}}

              <input id="edit_id" type="hidden" name="reply_id">
              <input id="edit_resident_id" type="hidden" name="residentId">

              <div class="form-group">
                <label>Message</label>
                <br>
                  <textarea id="edit_message" class="form-control" style="min-width: 100%" name="message"></textarea>
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

/*
$('.open-modal').click(function(){
    var reply_id = $(this).val();
    var topic_id = $(this).data('value');
    var url = '/php-group-project-c4i/public/LostFoundTopics';
    $.get(url + '/' +topic_id +'/'+ reply_id, function (data) {
        //success data
  console.log(data);

   var d = data[0];
   console.log(d);
   $('#edit_id').val(d.id);
   $('#edit_resident_id').val(d.residentId);
   $('#edit_message').val(d.message);

        $('#modal_edit').modal('show');
    })
});
*/
$('.open-modal').click(function(){
  var reply_id = $(this).val();
  var topic_id = $(this).data('value');
  console.log(topic_id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    $.ajax({
        type: "GET",
        url: "{{route('get_edit_reply', ['id'])}}",
        data: {id: topic_id, rid: reply_id}, // serializes the form's elements.
        success: function(data)
        {

          console.log(data);

           var d = data[0];
           console.log(d);
           $('#edit_id').val(d.id);
           $('#edit_resident_id').val(d.residentId);
           $('#edit_message').val(d.message);

                $('#modal_edit').modal('show');
        },
        error: function (data) {

          //console.log(data.responseText);
          console.log(data);
        }
      });

});

$(document).on('click','#btn_reply',function(){
    var form = $('#form_reply');
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
      //  $('#modal_reply').modal('hide');
        location.reload();
      },
      error: function (data) {
        alert(data['responseJSON']['message']);
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



$(document).on('click','#btn_remove',function(){
  var reply_id = $(this).val();
  var topic_id = $(this).data('value');
  console.log(topic_id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    $.ajax({
        type: "GET",
        url: "{{route('remove_reply', ['id'])}}",
        data: {id: topic_id, rid: reply_id}, // serializes the form's elements.
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

</script>

@stop
