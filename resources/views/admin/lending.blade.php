@extends('layout')

@section('index-content')

    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Item</th>
            <th scope="col">Borrower</th>
            <th scope="col">Borrower Email</th>
            <th scope="col">Borrower Phone</th>
            <th scope="col">Borrower Address</th>
            <th scope="col">Date</th>
        </tr>
        </thead>
        <tbody>
        @if(count($lendings) > 1)
            @foreach($lendings as $lending)
        <tr>
            <th scope="row">{{$lending->id}}</th>
            <td><a href="/lending/{{$lending->id}}">{{$lending->itemName}}</a></td>
            <td>{{$lending->borrowerName}}</td>
            <td>{{$lending->borrowerEmail}}</td>
            <td>{{$lending->borrowerPhone}}</td>
            <td>{{$lending->borrowerAddress}}</td>
            <td>{{$lending->borrowDate}}</td>
        </tr>
            @endforeach
        @else
            <p>No lending request</p>
        @endif
        </tbody>
    </table>


    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script> 
    <script>
        $(document).ready(function(){
            $('#li_lending').addClass('active');
        });
    </script>
@endsection