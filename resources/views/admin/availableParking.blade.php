@extends('layout')
@section('index-content')
    <div class="container card mb-3">
        <div class="card-body">
            <div class="-align-center" style="margin-bottom: 5%">
                <h4>LocationA</h4>
            </div>
            {{--model display current visitors--}}
            <div class="table-responsive" id="currentContent">
                <table class="table table-bordered"  width="20%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Number</th>
                    </tr>
                    </thead>
                    <tbody id="dataTable">
                    @foreach($spaceA as $one)
                        <tr>
                            <td>{{$one->number}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container card mb-3">
        <div class="card-body">
            <div class="-align-center" style="margin-bottom: 5%">
                <h4>LocationB</h4>
            </div>
            {{--model display current visitors--}}
            <div class="table-responsive" id="currentContent">
                <table class="table table-bordered"  width="20%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Number</th>
                    </tr>
                    </thead>
                    <tbody id="dataTable">
                    @foreach($spaceB as $one)
                        <tr>
                            <td>{{$one->number}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container card mb-3">
        <div class="card-body">
            <div class="-align-center" style="margin-bottom: 5%">
                <h4>LocationC</h4>
            </div>
            {{--model display current visitors--}}
            <div class="table-responsive" id="currentContent">
                <table class="table table-bordered"  width="20%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Number</th>
                    </tr>
                    </thead>
                    <tbody id="dataTable">
                    @foreach($spaceC as $one)
                        <tr>
                            <td>{{$one->number}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container card mb-3">
        <div class="card-body">
            <div class="-align-center" style="margin-bottom: 5%">
                <h4>LocationD</h4>
            </div>
            {{--model display current visitors--}}
            <div class="table-responsive" id="currentContent">
                <table class="table table-bordered"  width="20%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Number</th>
                    </tr>
                    </thead>
                    <tbody id="dataTable">
                    @foreach($spaceD as $one)
                        <tr>
                            <td>{{$one->number}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container card mb-3">
        <div class="card-body">
            <div class="-align-center" style="margin-bottom: 5%">
                <h4>LocationE</h4>
            </div>
            {{--model display current visitors--}}
            <div class="table-responsive" id="currentContent">
                <table class="table table-bordered"  width="20%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Number</th>
                    </tr>
                    </thead>
                    <tbody id="dataTable">
                    @foreach($spaceE as $one)
                        <tr>
                            <td>{{$one->number}}</td>
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
            $('#li_parking').addClass('active');
            $("#select_resident").select2();
        });
        // $(document).on('click','#btn_send',function(){
        //     var form = $('#form_send');
        //     var url = form.attr('action');
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     console.log(form.serialize());
        //     $.ajax({
        //         type: "POST",
        //         url: url,
        //         data: form.serialize(),
        //         success: function(data)
        //         {
        //             alert('Email send to the select resident successfully');
        //             location.reload();
        //         },
        //         error: function (data) {
        //             alert('error');
        //             console.log(data);
        //         }
        //     });
        // });
    </script>
@stop