@extends('layoutUser')
@section('index-content')

 <div class="container card mb-3">
      <div class="card-body">
        <div class="float-right" style="margin-bottom: 5%">
          <a class="btn btn-warning" href="{{route('message')}}" role="button">Back</a>

        </div>

        <div>
          <h1>Resident-Resident Messaging</h1>
        </div>
                <br>
      <div>
        <h2>Messages Sent</h2>
      </div>
              <br>
      <div class="table-responsive">


        @if (count($messagesSent) === 0)
              <p>No Messages Sent</p>
        @else
            @foreach($messagesSent as $one)
            <div class="card mb-3">
            <div class="card-body">

              <h6 class="card-title">Sent To: {{$one->name}} <span class="float-right">Date: {{$one->date}}</spam></h6>
              <p class="card-text">Subject: {{$one->subject}}</p>
              <p class="card-text">Message: {{$one->body}}</p>
            </div>
          </div>
            @endforeach
        @endif

    </div>
    {{ $messagesSent->appends(Request::except('page'))->links() }}
      </div>
  </div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#ui_message').addClass('active');

  });


</script>
@stop
