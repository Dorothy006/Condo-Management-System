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
                        <th>Lending Item</th>
                        <th>Borrower Name</th>

                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lending as $l)
                        <tr>
                            <td><input id="lending_{{$l->id}}" type="checkbox" class="form-control" name="lending[]" value="{{$l->id}}"></td>
                            <td>{{$l->itemName}}</td>
                            <td>{{$l->borrowerName}}</td>
                            <td>{{$l->borrowDate}}</td>
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
                    <h4 class="modal-title">Adding new lending record</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form id="form_add" method="post" action="{{route('add_lendings')}}">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Lending Item</label>
                            <input type="text" class="form-control" name="itemName"  placeholder="Item name">
                        </div>
                        <div class="form-group">
                            <label>Borrower Name</label>
                            <input type="text" class="form-control" name="borrowerName"  placeholder="Borrower name">
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" class="form-control" name="borrowDate" placeholder="Borrow date">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" id="btn_add" class="btn btn-primary">Submit</button>
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
                <form id="form_update" method="post" action="{{route('update_lendings')}}">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Select a lending record to update</label>
                            <select id="update_id" name="id" placeholder="Select a lending record" style="width: 300px;">
                                <option value=""></option>

                                @foreach($lending as $l)
                                    <option value="{{$l->id}}">{{$l->itemName}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Lending Item</label>
                            <input id="update_lendingItem" type="text" class="form-control" name="itemName" placeholder="Enter item">
                        </div>
                        <div class="form-group">
                            <label>Borrower Name</label>
                            <input id="update_borrowerName" type="text" class="form-control" name="borrowerName" placeholder="Enter borrower name">
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input id="update_borrowerDate" type="date" class="form-control" name="borrowDate" placeholder="Enter borrowed date">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
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
                    <h4 class="modal-title">Are you sure to delete these lending records?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>


                <!-- Modal body -->
                <form id="form_delete" method="post" action="{{route('delete_lendings')}}">
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
            $('#li_lending').addClass('active');
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
            if($('input[name="lending[]"]:checked').length>0){
                $('input[name="lending[]"]:checked').each(function(){
                    arr.push($(this).val());
                });
                $('#remove_list').val(arr);
                $('#modal_delete').modal('toggle');
            }else{
                snackbar('Select at least one lending to remove.');
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
