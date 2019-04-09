<!DOCTYPE html>
<html lang="en">

  <head>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>C4I</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">


    <!-- Page level plugin CSS-->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Using Select2 -->
    <!-- <link href="vendor/select2/select2.min.css" rel="stylesheet"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin.css')}}" rel="stylesheet">


  </head>

  <body id="page-top">

        <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="{{route('console')}}">C4I Console</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

      </div>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>

    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
     <ul class="sidebar navbar-nav">
  <li id="li_dashboard" class="nav-item">
    <a class="nav-link" href="{{ route('console') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <li id="li_resident" class="nav-item">
    <a class="nav-link" href="{{route('resident')}}">
      <i class="fas fa-user"></i>
      <span>Resident list</span></a>
  </li>
  <li id="li_rooms" class="nav-item">
    <a class="nav-link" href="{{route('room')}}">
      <i class="fas fa-door-open"></i>
      <span>Rooms</span></a>
  </li>

  <li id="li_email" class="nav-item">
    <a class="nav-link" href="{{route('send_from')}}">
      <i class="fas fa-envelope"></i>
      <span>Send Form</span></a>
  </li>
  <li id="li_visitorLogIn" class="nav-item">
      <a class="nav-link" href="{{route('visitorLogin')}}">
          <i class="fas fa-sign-in-alt"></i>
          <span>Visitor LogIn</span></a>
  </li>
  <li id="li_visitor" class="nav-item">
    <a class="nav-link" href="{{route('visitor')}}">
      <i class="fas fa-users"></i>
      <span>VisitorList</span></a>
  </li>
  <li id="li_parking" class="nav-item">
    <a class="nav-link" href="{{route('parking_space')}}">
      <i class="fas fa-car"></i>
      <span>Parking</span></a>
  </li>

  <li id="li_package" class="nav-item">
    <a class="nav-link" href="{{route('package')}}">
      <i class="fas fa-boxes"></i>
      <span>Package</span></a>
  </li>
  <li id="li_lostFound_topic" class="nav-item">
    <a class="nav-link" href="{{route('LostFoundTopicsAdmin')}}">
      <i class="fas fa-box-open"></i>
      <span>Lost Found</span></a>
  </li>
  <li id="li_announcement" class="nav-item">
    <a class="nav-link" href="{{route('announcement')}}">
      <i class="fas fa-comments"></i>
      <span>Announcement</span></a>
  </li>
<li id="li_event" class="nav-item">
    <a class="nav-link" href="{{route('event')}}">
      <i class="fas fa-hotel"></i>
      <span>Event</span></a>
  </li>

  <li id="li_lending" class="nav-item">
    <a class="nav-link" href="{{route('lendings')}}">
      <i class="fas fa-book"></i>
      <span>Lending books</span></a>
  </li>

  <li id="li_repair" class="nav-item">
    <a class="nav-link" href="{{route('repair')}}">
      <i class="fas fa-hammer"></i>
      <span>Repair</span></a>
  </li>
</ul>
<!-- <div id="mysnackbar"></div>
 -->
@yield('index-content')

        <div>@yield('content')</div>

      </div>

      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
<!--       <footer class="sticky-footer" style="margin-top: 10%">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © C4I 2018</span>
            </div>
          </div>
        </footer> -->
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="{{route('logout')}}">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Using select2 -->
    <!-- <script src="vendor/select2/select2.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Page level plugin JavaScript-->
    <script src="{{asset('vendor/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin.min.js')}}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  </body>

</html>

<script type="text/javascript">
  function snackbar(text){

    $('#mysnackbar').attr('class','show');
      $('#mysnackbar').html(text);
      setTimeout(function(){  $('#mysnackbar').attr('class','');}, 3000);
  }

</script>
