@extends('layoutUser')
@section('index-content')
 <div id="content-wrapper">
    <div class="container-fluid">

      <section class="jumbotron text-center">
        <div class="container">

          @if ($time < "12")
                  <h1 class="jumbotron-heading">Good Morning, {{$resident->name}}</h1>
                  <h1 class="jumbotron-heading">Welcome Back!</h1>
          @elseif ($time >= "12" && $time < "17")
                  <h1 class="jumbotron-heading">Good Afternoon, {{$resident->name}}</h1>
                  <h1 class="jumbotron-heading">Welcome Back!</h1>
          @elseif ($time >= "17" && $time < "19")
                  <h1 class="jumbotron-heading">Good Evening, {{$resident->name}}</h1>
                  <h1 class="jumbotron-heading">Welcome Back!</h1>
          @else
                  <h1 class="jumbotron-heading">Good Night, {{$resident->name}}</h1>
          @endif



          <p class="lead text-muted">
            <script> document.write(new Date().toDateString()); </script>
          </p>
        </div>

        <!-- Portfolio Item Row -->
          <div class="row">


            <div class="col-md-4">

              <h3 class="my-3">Announcements</h3>
              @foreach($announcements as $one)
              <ul class="list-group list-group-flush">
                <li class="list-group-item">{{$one->announce_desc}}
                  <br/>{{$one->date}}
                  @if($one->time !== '00:00:00')
                  <br/>{{$one->time}}
                  @endif
                </li>
              </ul>
              @endforeach
            </div>
            <div class="col-md-4">

              <h3 class="my-3">Notifications

                @if(App\Residents::find(session()->get('resident_id'))->unreadNotifications->count())
                 <span class="badge badge-secondary">{{App\Residents::find(session()->get('resident_id'))->unreadNotifications->count()}}</span>
                 @endif
               </h3>

              @foreach(App\Residents::find(session()->get('resident_id'))->unreadNotifications as $one)

                <ul class="list-group list-group-flush">
                  @if($one->data['type'] === 'message')
                      <li class="list-group-item">

                        Message From: {{$one->data['sender']['name']}}
                        <a href="{{route('read_Noti', ['id' => $one->id])}}"> <i class="fa fa-envelope"> </i></a>
                      </li>
                    @elseif($one->data['type'] === 'visitorMessage')
                    <li class="list-group-item">

                       {{$one->data['visitor']['name']}}  want to visit you

                      <a href="{{route('verify_visitor_true', ['id' => $one->id,'name'=>$one->data['visitor']['name'],'email'=>$one->data['visitor']['email']
                      ,'phone'=>$one->data['visitor']['phone'],'roomNumber'=>$one->data['visitor']['roomNumber']])}}">
                        <i class="fa fa-check-square"> </i></a>

                      <a href="{{route('verify_visitor_false',['id' => $one->id])}}">
                            <i class="fa fa-window-close"> </i></a>
                    </li>
                    @endif
              </ul>
              @endforeach
            </div>
          </div>

      </section>

      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fas fa-fw fa-comments"></i>
              </div>
              <div class="mr-5">Send Message</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{route('message')}}">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fas fa-fw fa-user"></i>
              </div>
              <div class="mr-5">My VisitorsList </div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{route('myVisitorList')}}">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fab fa-fort-awesome"></i>
              </div>
              <div class="mr-5">Facility Booking</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{route('facility_booking')}}">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fas fa-book"></i>
              </div>
              <div class="mr-5">Lost and Found Board</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{route('LostFoundTopics')}}">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>


      </div>
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-car"></i>
              </div>
              <div class="mr-5">Repair Report</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{route('userRepair')}}">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
               <i class="fas fa-envelope"></i>
              </div>
              <div class="mr-5">Payments</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{route('payment')}}">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
               <i class="fas fa-bell"></i>
              </div>
              <div class="mr-5">Events</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{route('userEvent')}}">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>


      </div>

      </div>
  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#ui_dashboard').addClass('active');
  });
</script>
@stop
