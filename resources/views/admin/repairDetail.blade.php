@extends('layout')

@section('index-content')
    <div class="form-group">
    <div class="card shadow p-3 mb-5 bg-white rounded">
        <h1>{{$repairs->repairTitle}}</h1>
        <br>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Resident Name</th>
                <th scope="col">Email</th>
                <th scope="col">Room Number</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Please repair at</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$repairs->name}}</td>
                <td>{{$repairs->email}}</td>
                <td>{{$repairs->roomNumber}}</td>
                <td>{{$repairs->phone}}</td>
                <td>{{$repairs->repairTime}}</td>
            </tr>
            </tbody>
        </table>
        <br>
        <h2>Repair Request Detail</h2>
        <div class="card-body">
            {{$repairs->repairDetail}}
        </div>

    </div>
    <button type="button" class="btn btn-dark" onclick="window.location.href='/repair'">Back</button>
    </div>
@endsection