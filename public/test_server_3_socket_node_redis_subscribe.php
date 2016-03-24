<html>
    <head>
        <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
        <script>
            var socket= io(':3000');//"https://webapp.dev:3000/" (last '/' is optional)

            socket.on('connect', function(){
                console.log('connect');
            });
            socket.on('disconnect', function(){
                console.log('disconnected');
            });

            socket.on('example-channel:MyEvent', function(data){
                var message_div= document.getElementById("message-container");
                message_div.innerHTML+= "<br/><br/>"+data;
                console.log(data);
            });
            console.log("Data will be loged here.");
        </script>
    </head>
    <body>
        <b>Node.js Socket.io doesn't work on <u style="color: #ff0000;">Firefox</u> with self signed certificate. It does work fine on Chrome and Internet Explorer.</b>
        <div id="message-container" style="background-color: #009900;">
            Message will be appended here.
        </div>
    </body>
</html>
