@extends('layout')
@section('index-content')

 <div class="container card mb-3">
      <div class="card-body">
        <div class="float-right" style="margin-bottom: 5%">
        </div>
        <div>
          <h2>Lost and Found Manager</h2>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Subject</th>
                <th>Category</th>
                <th>Message</th>
                <th>Date Posted</th>
                <th>Reply Count</th>
              </tr>
            </thead>
            <tbody>
              @foreach($lostFoundTopics as $one)
              <tr>
                <td><a  href="{{route('LostFoundReplysAdmin', ['id' => $one->id])}}">{{$one->subject}}</a></td>
                @if($one->category === 0)
                <td>Lost</td>
                @else
                <td>Found</td>
                @endif
                <td>{{$one->message}}</td>
                <td>{{$one->date}}</td>
                <td>{{$one->reply_count}}</td>
                <td>

                  <button id="btn_remove" class="btn btn-danger btn-detail" value="{{$one->id}}">Remove</button>
                 </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
  </div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>


<script type="text/javascript">
$(document).ready(function(){
    $('#li_lostFound_topic').addClass('active');
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
          console.log(data);
          location.reload();
        },
        error: function (data) {

          console.log(data);
        }
      });

});

</script>
@stop
