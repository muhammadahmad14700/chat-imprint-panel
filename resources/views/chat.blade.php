@extends('layouts.admin.app')
@section('title', 'Page Title')
@section('sidebar')
<!-- 
parent
    <p>This is appended to the master sidebar.</p>
endsection
-->
@section('content')
<!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
             <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Chat</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
			<!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Sales Cards  -->
                <!-- ============================================================== -->
                
				<!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                </div>
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
			</div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
			<!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved by Mudassar Rauf. Designed and Developed by <a href="#">Mudassar Rauf</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
            
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.0.1/socket.io.min.js" integrity="sha512-gVG6WRMUYFaIdoocaxbqd02p3DUbhReTBWc7NTGB96i7vONrr7GuCZJHFFmkXEhpwilIWUnfRIMSlKaApwd/jg==" crossorigin="anonymous"></script>
        <script>
        let userId = 1;
        let chatId = null;
        const socket = io("ws://35.233.45.129:9000", {
        path: '/chat',
        transports: ["websocket"],
        auth: {
          token: "dvkl51dpk130t5jwq69gubz5"
        }
      });
      socket.on('connect', () => {
        console.log("User Connected: ", socket.id);
        initialize();
      });
      socket.on('connect_timeout', () => {
        console.log("Connect Timeout");
      });

      socket.io.on('reconnect', (attemptNumber) => {
        console.log("User Reconnected: ", attemptNumber);
      });

      // reconnect_attemp and reconnecting events are same
      socket.io.on('reconnect_attempt', (attemptNumber) => {
        socket.io.opts.transports = ['websocket'];
        console.log("Reconnect attempt: ", attemptNumber)
      });

      socket.io.on('reconnect_error', (err) => {
        console.log("Reconnect error: ", err)
      });

      socket.io.on('reconnect_failed', () => {
        console.log("Reconnect Failed")
      });

      socket.io.on('error', (err) => {
        console.log("Connect Error: ", err);
      });

      socket.on('disconnect', (reason) => {
        /* reason will be 'transport close' when server stopped sending data
        reason will be 'io server disconnect' when server performs socket.disconnect()
        reason will be 'io client disconnect' when client performs socket.disconnect()
        reason will be 'ping timeout' when ping timeout occurs */
        if (reason === 'io server disconnect') {
          // do something
        }
        console.log("User disconnected: ", reason);
      });

      socket.on('clientError', (data) => {
        console.error(data.msg);
      });

      socket.on('startChatSession', (data) => {
        console.log("You have a new chat session");
        console.log(data);
        chatId = data.chatId;
      });

      socket.on('receiveChatMessage', (data) => {
        let msg = "Customer: " + data.message.body;
        $('#messages').append($('<li>').text(msg));
      });

      socket.on('seenChatMessages', (data) => {
        console.log("Representative has seen messages", data);
      });

      socket.on('typing', (data) => {
        console.log("Customer is typing", data);
      });

      socket.on('stopTyping', (data) => {
        console.log("Customer has stopped typing", data);
      });

      socket.on('endChatSession', (data) => {
        console.log("Customer left: ", data);
      });


      function initialize() {
        socket.emit('initialize', { 
          userId: userId
        }, (data) => console.log(data, "data"));
      }

        
        </script>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->

@endsection			
			