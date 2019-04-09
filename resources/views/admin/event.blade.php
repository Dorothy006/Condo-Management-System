@extends('layout')

@section('index-content')
    <div class="container card mb-3">
        <div class="card-body">
            <div class="float-right" style="margin-bottom: 5%">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add">Add</button>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_update">Update</button>
                <button type="button" class="btn btn-danger" id="btn_modal_remove">Remove</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Event Title</th>
                        <th>Event Description</th>
                        <th>Event Address</th>
                        <th>Event Date</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($events as $l)
                        <tr>
                            <td><input id="event_{{$l->id}}" type="checkbox" class="form-control" name="event[]" value="{{$l->id}}"></td>
                            <td style="width: 200px;">{{$l->eventTitle}}</td>
                            <td style="width: 300px;">{{$l->eventDes}}</td>
                            <td>{{$l->eventAddress}}</td>
                            <td>{{$l->eventDate}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal" id="modal_add">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Adding new event</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form id="form_add" method="post" action="{{route('add_event')}}">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Events Title</label>
                            <input type="text" class="form-control" name="eventTitle"  placeholder="Event Title">
                        </div>
                        <div class="form-group">
                            <label>Event Description</label>
                            <input type="text" class="form-control" name="eventDes"  placeholder="Event Description">
                        </div>
                        <div class="form-group">
                            <label>Event Address</label>
                            <input type="text" class="form-control" name="eventAddress"  placeholder="Event Address">
                        </div>
                        <div class="form-group">
                            <label>Event Date</label>
                            <input type="date" class="form-control" name="eventDate"  placeholder="Event Date">
                        </div>

                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" id="btn_add" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="modal_update">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 id="update_title" class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form id="form_update" method="post" action="{{route('update_event')}}">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Select a event to update</label>
                            <select id="update_id" name="id" placeholder="Select a event" style="width: 300px;">
                                <option value=""></option>

                                @foreach($events as $l)
                                    <option value="{{$l->id}}">{{$l->eventTitle}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Events Title</label>
                            <input id="update_eventTitle" type="text" class="form-control" name="eventTitle" placeholder="Enter event title">
                        </div>
                        <div class="form-group">
                            <label>Event Description</label>
                            <input id="update_eventDes" type="text" class="form-control" name="eventDes" placeholder="Enter event description">
                        </div>
                        <div class="form-group">
                            <label>Event address</label>
                            <input id="update_eventAddress" type="text" class="form-control" name="eventAddress" placeholder="Enter event address">
                        </div>
                        <div class="form-group">
                            <label>Event date</label>
                            <input id="update_eventDate" type="date" class="form-control" name="eventDate" placeholder="Enter event date">
                        </div>

                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" id="btn_update" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="modal_delete">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Are you sure to delete these events?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form id="form_delete" method="post" action="{{route('delete_event')}}">
                    <input type="text" id="remove_list" name="remove_list" hidden>
                </form>
                <div class="modal-footer">
                    <button type="button"  data-dismiss="modal" class="btn btn-primary">Close</button>
                    <button type="button" id="btn_delete" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function(){
            $('#li_event').addClass('active');
            $("#update_id").select2();
        });
        $('#update_id').on('change', function (e) {

        });
        $('#update_id').on('select2:select',function(){
            alert('123123');


        });
        $(document).on('click','#btn_add',function(){
            var form = $('#form_add');
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
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    $('#modal_add').modal('hide');
                    location.reload();
                },
                error: function (data) {
                    alert('error');
                    console.log(data);
                }
            });
        });
        $(document).on('click','#btn_update',function(){
            var form = $('#form_update');
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
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    alert(data);
                    $('#modal_update').modal('hide');
                    location.reload();
                },
                error: function (data) {
                    alert('error');
                    console.log(data);
                }
            });
        });
        $(document).on('click','#btn_modal_remove',function(){
            var arr=[];
            if($('input[name="event[]"]:checked').length>0){
                $('input[name="event[]"]:checked').each(function(){
                    arr.push($(this).val());
                });
                $('#remove_list').val(arr);
                $('#modal_delete').modal('toggle');
            }else{
                snackbar('Select at least one event to remove.');
            }
        });
        $(document).on('click','#btn_delete',function(){

            var form = $('#form_delete');
            var url = form.attr('action');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            console.log(form.serialize());
            $.ajax({
                type: "GET",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    snackbar(data);
                    $('#modal_delete').modal('hide');
                    location.reload();
                },
                error: function (data) {

                    console.log(data.responseText);
                    console.log(data);
                }
            });
        });
    </script>
@stop
