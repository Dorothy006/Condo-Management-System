@extends('layoutUser')
@section('index-content')
    <div class="container card mb-3">
        <div class="card-body">
            <div class="float-right" style="margin-bottom: 5%">
                <button type="button" class="btn btn-danger" id="btn_modal_remove">Pay for your fee</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Room Number</th>
                        <th>Descriptions</th>
                        <th>Fee</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payment as $one)
                        <tr>
                            <td><input id="payment_{{$one->id}}" type="checkbox" class="form-control" name="payments[]" value="{{$one->id}}"></td>
                            <td>{{$one->roomNumber}}</td>
                            <td>{{$one->des}}</td>
                            <td>${{$one->fees}}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{--delete a facility booking--}}
    <div class="modal" id="modal_delete">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Are you sure to pay this paymentss?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form id="form_delete" method="post" action="{{route('pay_fee')}}">
                    <input type="text" id="remove_list" name="remove_list" hidden>
                </form>
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div>
                            <label>Credit Card Number: </label>
                            <input id="cc-number" type="text" maxlength="20" autocomplete="off" value="" autofocus />
                        </div>
                        <div>
                            <label>CVC: </label>
                            <input id="cc-cvc" type="text" maxlength="4" autocomplete="off" value=""/>
                        </div>
                        <div>
                            <label>Expiry Date: </label>
                            <select id="cc-exp-month">
                                <option value="01">Jan</option>
                                <option value="02">Feb</option>
                                <option value="03">Mar</option>
                                <option value="04">Apr</option>
                                <option value="05">May</option>
                                <option value="06">Jun</option>
                                <option value="07">Jul</option>
                                <option value="08">Aug</option>
                                <option value="09">Sep</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
                            </select>
                            <select id="cc-exp-year">
                                <option value="15">2015</option>
                                <option value="16">2016</option>
                                <option value="17">2017</option>
                                <option value="18">2018</option>
                                <option value="19">2019</option>
                                <option value="20">2020</option>
                                <option value="21">2021</option>
                                <option value="22">2022</option>
                                <option value="23">2023</option>
                                <option value="24">2024</option>
                            </select>
                        </div>
                    </div>


                <div class="modal-footer">
                    <button type="button"  data-dismiss="modal" class="btn btn-primary">Close</button>
                    <button type="button" id="btn_delete" class="btn btn-danger">Pay</button>
                </div>
            </div>
        </div>


    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function(){
          $('#ui_payments').addClass('active');
        });

        $(document).ready(function(){
            $('#li_payments').addClass('active');
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
                    alert(data);
                    location.reload();

                },
                error: function (data) {
                    alert(data);
                    console.log(data);
                    console.log(data.responseText);
                }
            });
        });
        $(document).on('click','#btn_modal_remove',function(){
            var arr=[];
            if($('input[name="payments[]"]:checked').length>0){
                $('input[name="payments[]"]:checked').each(function(){
                    arr.push($(this).val());
                });
                $('#remove_list').val(arr);
                $('#modal_delete').modal('toggle');
            }else{
                alert('Select at least one facility booking to remove.');
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
                    alert(data);
                    $('#modal_delete').modal('hide');
                    location.reload();
                },
                error: function (data) {
                    alert(data);
                    console.log(data.responseText);
                    console.log(data);
                }
            });
        });
    </script>
@stop
