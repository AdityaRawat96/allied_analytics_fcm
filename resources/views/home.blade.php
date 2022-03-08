@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form id="notification-form">
                        @csrf
                        <div class="form-group">
                            <label>Message Title</label>
                            <input type="text" class="form-control" name="title" id="message-title">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" name="body" id="message-body"></textarea>
                        </div><br>
                        <button type="submit" class="btn btn-primary btn-block">Send Notification</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Notification Modal -->
<div class="modal" id="notification-modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">New Notification</h4>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <h3 id="notification-title"></h3>
        <p id="notification-body"></p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
</div>

<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    var firebaseConfig = {
         apiKey: "AIzaSyBPvLFD_SXfrYaSx7Kicdu2G0iYDNIiyLw",
        authDomain: "allied-fcm.firebaseapp.com",
        projectId: "allied-fcm",
        storageBucket: "allied-fcm.appspot.com",
        messagingSenderId: "437743599244",
        appId: "1:437743599244:web:149ff381e30c61a12645a9",
        measurementId: "G-2XEBSMLK76"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
      function startFCM() {
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (response) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route("store.token") }}',
                    type: 'POST',
                    data: {
                        token: response
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        console.log(response)
                    },
                    error: function (error) {
                        alert(error);
                    },
                });
            }).catch(function (error) {
                alert(error);
            });
    }
    messaging.onMessage(function (payload) {
        $("#notification-title").html(payload.notification.title);
        $("#notification-body").html(payload.notification.body);
        $('#notification-modal').modal('show');
    });


    $(document).ready(function(){
        //Initialize Firebase messaging
    startFCM();

        $("#notification-form").on('submit', function(e){
            e.preventDefault();
             $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route("send.notification") }}',
                    type: 'POST',
                    data: {
                        title: $("#message-title").val(),
                        body: $("#message-body").val(),
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        console.log(response)
                         $("#message-title").val("");
                        $("#message-body").val("");
                    },
                    error: function (error) {
                        alert(error);
                    },
                });
        })
    })
</script>
@endsection