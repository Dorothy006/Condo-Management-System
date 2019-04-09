@extends('layout')
@section('index-content')

<div class="container card mb-3">
     <div class="card-body">
       <div class="float-right" style="margin-bottom: 5%">
       </div>

       <div>
         <h2>Lost and Found Manager</h2>
       </div>

         @foreach($topic as $t)
          <h3>Topic Subject: {{$t->subject}}</h3>
          <h5>Topic Messsage: {{$t->message}}</h5>
         @endforeach
         @if(count($lostFoundReplies) === 0)
          <p>No Replies at the Moment</p>
         @else
         <div>
           <hr>
         </div>
       <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           <thead>
             <tr>
               <th>Resident Id | Email</th>
               <th>Message</th>
               <th>Date Posted</th>
             </tr>
           </thead>
           <tbody>
             @foreach($lostFoundReplies as $one)
             <tr>
               <td>{{$one->residentId}} | {{$one->email}}</td>
               <td>{{$one->message}}</td>
               <td>{{$one->date}}</td>
               <td>
                    <button  id="btn_remove" class="btn btn-xs btn-danger" data-value="{{$one->topicId}}" value="{{$one->id}}">Remove</button>

                </td>
             </tr>
             @endforeach
           </tbody>
         </table>
       </div>
       @endif
     </div>
 </div>






<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('#li_lostFound_topic').addClass('active');
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
