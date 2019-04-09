@extends('layoutUser')
@section('index-content')

    <div class="container card mb-3">
        <div class="card-body">
            <div class="float-right" style="margin-bottom: 5%">
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_search">Search</button>
            </div>
            {{--model display current visitors--}}
            <div class="table-responsive" id="currentContent">
                <table class="table table-bordered"  width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Time_In</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody id="dataTable">
                    @foreach($myVisitors as $one)
                        <tr>
                            <td>{{$one[1]}}</td>
                            <td>{{$one[2]}}</td>
                            <td>{{$one[3]}}</td>
                            <td>{{$one[4]}}</td>
                            <td><button class="ajax_button" data-id="{{$one[0]}} " >LogOut</button></td>
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
            $('#ui_myVisitorList').addClass('active');
        });
        $(".ajax_button").click(function(){
            // var form = $('#visitor_LogOut');
            // var url = form.attr('action');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var id = $(this).data("id");
            console.log(id);
            $.ajax({
                type: "GET",
                url: 'http://localhost/php-group-project-c4i/public/myVisitor/logOut',
                data: { id: id },
                success: function(data)
                {
                    alert('Log Out Successfully.');
                    location.reload();
                    // console.log(data);
                },
                error: function (data) {
                    alert('error');
                    // console.log(data);
                }
            });
        });

    </script>

@stop
