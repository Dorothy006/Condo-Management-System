@extends('layout')

@section('index-content')
    <div class="card col ">
        <h5 class="card-header">{{$lendings->itemName}}</h5>
        <div class="card-body">
            <h5 class="card-title">Borrower Name</h5>
            <p class="card-text">{{$lendings->borrowerName}}</p>
            <h5 class="card-title">Borrower Email</h5>
            <p class="card-text">{{$lendings->borrowerEmail}}</p>
            <h5 class="card-title">Borrower Phone</h5>
            <p class="card-text">{{$lendings->borrowerPhone}}</p>
            <h5 class="card-title">Borrower Address</h5>
            <p class="card-text">{{$lendings->borrowerAddress}}</p>
            <h5 class="card-title">Borrow Date</h5>
            <p class="card-text">{{$lendings->borrowDate}}</p>
            <a href="#" class="btn btn-primary" onclick="window.location.href='/lending'">Returned back</a>
            <a href="#" class="btn btn-primary" onclick="window.location.href='/lending'">Extend Date</a>
        </div>
    </div>





    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script> 
    <script>
        $(document).ready(function(){
            $('#li_lending').addClass('active');
        });
    </script>
@endsection