@extends('layout')
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
                        <th>Room Number</th>
                        <th>Time_In</th>
                        <th>Status</th>
                        <th>Last_Time</th>
                    </tr>
                    </thead>
                    <tbody id="dataTable">
                    @foreach($visitors as $one)
                        <tr>
                            <td>{{$one->name}}</td>
                            <td>{{$one->email}}</td>
                            <td>{{$one->phone}}</td>
                            <td>{{$one->roomNumber}}</td>
                            <td>{{$one->created_at}}</td>
                            @if(((int)($one->last_time))==0)
                                <td><span class="btn-primary rounded">Activity</span></td>
                                <td></td>
                            @else
                                <td><span class="btn-danger rounded">Logged Out</span></td>
                                @if((int)($one->last_time)>999999)
                                    <td>{{intval((int)($one->last_time)/1000000)}} Days</td>
                                @elseif((int)($one->last_time)>99999)
                                    @if(intval((int)($one->last_time)/10000) >24)
                                        <td>{{intval((int)($one->last_time)/10000-76)}} Hours</td>
                                    @else
                                    <td>{{intval((int)($one->last_time))/10000}} Hours</td>
                                    @endif
                                @else
                                    <td>Less than 1 Hour</td>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    {{--model search--}}
    <div class="modal" id="modal_search">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Search</h4>
                    <button type="button" class="close" data-dismiss="modal">&times</button>
                </div>
                <!-- Modal body -->
                <form id="form_search" method="post" action="{{route('search_visitor')}}">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>How you want to search?</label>
                            <select class="form-control" name="searchBy">
                                <option>name</option>
                                <option>email</option>
                                <option>phone</option>
                            </select>
                            <br>
                            <input id="searchKey" type="text" class="form-control" name="searchKey" placeholder="Enter Key words here">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" id="btn_search" class="btn btn-primary">Search</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#li_visitor').addClass('active');
    });
    $(document).on('click','#btn_search',function(){
        var form = $('#form_search');
        var url = form.attr('action');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log(form.serialize());
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(data)
            {
                $('#modal_search').modal('hide');

                var string ="";
                for(var i=0;i<data.length;i++){
                    string+= "<tr>";
                    jQuery.each(data[i],function(){
                        string+="<td>"+this+"</td>";
                    });
                    string+= "</tr>";
                }
                $('#dataTable').html(string);
                
            },
            error: function (data) {
                alert('error');
                console.log(data);
            }
        });
        });
</script>

@stop