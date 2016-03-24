//Example from Laravel documentation
var fs = require('fs');
var options = {
    key: fs.readFileSync('/etc/letsencrypt/privkey.pem'),
    cert: fs.readFileSync('/etc/letsencrypt/fullchain.pem')
}

var app = require('https').createServer(options, handler);
var io = require('socket.io')(app);

var Redis = require('ioredis');
var redis = new Redis(6379, 'redis');

app.listen(3000, function() {
    console.log('Server is running!');
});

function handler(req, res) {
    res.writeHead(200);
    res.end('');
}

io.on('connection', function(socket) {
    //
});

redis.psubscribe('*', function(err, count) {
    //
});

redis.on('pmessage', function(subscribed, channel, message) {
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});
