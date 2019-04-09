@extends('layoutUser')

@section('content')

    @if(count($events) > 1)
        @foreach($events as $event)

            <div class="list-group-item shadow p-3 mb-5 bg-white rounded">
                <h3><a href="/event/{{$event->id}}">{{$event->eventTitle}}</a></h3>
                <p class="text-secondary">{{$event->eventDes}}</p>
                <br>
                <div  class="text-info">
                    <small>Event Address:  {{$event->eventAddress}} </small>
                    <br>
                    <small>Reported at:  {{$event->eventDate}} </small>
                </div>
            </div>
        @endforeach


    @else

    @endif
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script> 
    <script>
        $(document).ready(function(){
            $('#ui_events').addClass('active');
        });
    </script>
@stop