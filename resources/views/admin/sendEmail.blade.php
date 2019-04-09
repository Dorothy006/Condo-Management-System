@extends('layout')
@section('index-content')
    <div class="container card mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <form id="form_send" method="post" action="{{route('send_email')}}">
                    <h4 style="text-align: center">Send Email to residents</h4>
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label id="test">Select a resident:</label><br>
                            <select id="select_resident" name="select_resident[]" placeholder="Select residents" style="width: 300px;" multiple="multiple">
                                <option value=""></option>
                                @foreach($residents as $one)
                                    <option value="{{$one->email}}">{{$one->roomid}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Topic</label><br>
                            <input id="message_topic" type="text" class="form-control" name="message_topic" placeholder="Topic From Here">
                        </div>
                        <div class="form-group">
                            <label>Content</label><br>
                            <textarea id="message_content" type="text" class="form-control" name="message_content" placeholder="Content From Here"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn_send" class="btn btn-primary">Send</button>
                        <button type="button" id="btn_cancle" class="btn btn-danger" >Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#li_email').addClass('active');
            $("#select_resident").select2();
        });
        $(document).on('click','#btn_send',function(){
            var form = $('#form_send');
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
                    alert('Email send to the select resident successfully');
                    location.reload();
                },
                error: function (data) {
                    alert('error');
                    console.log(data);
                }
            });
        });
        $(document).on('click','#btn_cancle',function(){
            location.reload();
        });
    </script>
    @stop