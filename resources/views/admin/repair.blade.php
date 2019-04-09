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
                        <th>Repair Request</th>
                        <th>Repair Detail</th>
                        <th>Room number</th>
                        <th>Repair Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($repairs as $l)
                        <tr>
                            <td><input id="repair_{{$l->id}}" type="checkbox" class="form-control" name="repair[]" value="{{$l->id}}"></td>
                            <td>{{$l->repairTitle}}</td>
                            <td>{{$l->repairDetail}}</td>
                            <td>{{$l->roomNumber}}</td>
                            <td>{{$l->repairTime}}</td>
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
                    <h4 class="modal-title">Adding new Repair Request</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form id="form_add" method="post" action="{{route('add_repairs')}}">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Repair Request</label>
                            <input type="text" class="form-control" name="repairTitle"  placeholder="Repair Request">
                        </div>
                        <div class="form-group">
                            <label>Repair Detail</label>
                            <input type="text" class="form-control" name="repairDetail"  placeholder="Room Number">
                        </div>
                        <div class="form-group">
                            <label>Room Number</label>
                            <input type="text" class="form-control" name="roomNumber"  placeholder="Room Number">
                        </div>
                        <div class="form-group">
                            <label>Repair Date</label>
                            <input type="date" class="form-control" name="repairTime" placeholder="Repair Time">
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
                <form id="form_update" method="post" action="{{route('update_repairs')}}">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Select a repair request to update</label>
                            <select id="update_id" name="id" placeholder="Select a repair request" style="width: 300px;">
                                <option value=""></option>

                                @foreach($repairs as $l)
                                    <option value="{{$l->id}}">{{$l->repairTitle}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Repair Title</label>
                            <input id="update_repairTitle" type="text" class="form-control" name="repairTitle" placeholder="Enter item">
                        </div>
                        <div class="form-group">
                            <label>Repair Detail</label>
                            <input id="update_repairDetail" type="text" class="form-control" name="repairDetail" placeholder="Enter borrower name">
                        </div>
                        <div class="form-group">
                            <label>Room Number</label>
                            <input id="update_roomNumber" type="text" class="form-control" name="roomNumber" placeholder="Enter borrower name">
                        </div>
                        <div class="form-group">
                            <label>Repair Date</label>
                            <input id="update_repairTime" type="date" class="form-control" name="repairTime" placeholder="Enter borrowed date">
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
                    <h4 class="modal-title">Are you sure to delete these repair request?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form id="form_delete" method="post" action="{{route('delete_repairs')}}">
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
            $('#li_repair').addClass('active');
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
            if($('input[name="repair[]"]:checked').length>0){
                $('input[name="repair[]"]:checked').each(function(){
                    arr.push($(this).val());
                });
                $('#remove_list').val(arr);
                $('#modal_delete').modal('toggle');
            }else{
                snackbar('Select at least one repair to remove.');
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
