/*
docker run --rm -it --user=$(id -u):$(id -g) -v "$PWD":/usr/src/app node:6.9.2 /bin/bash
docker run --rm -it --user=$(id -u):$(id -g) -v $(pwd):/usr/share/nginx/WEBAPP rasodu/cmdlaravel:7.0.1 /bin/bash
*/
var http = require('http');

var server = http.createServer(function (request, response) {
  response.writeHead(200, {"Content-Type": "text/plain"});
  response.end("Hello World\n");
});

server.listen(8080);

console.log("Server running at http://0.0.0.0:8080/");
