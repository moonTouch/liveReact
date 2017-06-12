
var http = require('http');
var fs = require('fs');

// Loading index.php displayed to client
var server = http.createServer(function(req, res) {
    fs.readFile('./index.php', 'utf-8', function(error, content) {
        res.writeHead(200, {"Content-Type": "text/html"});
        res.end(content);
    });
});

server.listen(8080);

// Loading socket.io
var io = require('socket.io').listen(server);


//Unique to each user
io.sockets.on('connection', function (socket) {
   
    socket.on('image', function (image) {
        socket.broadcast.emit('image', image);
    }); 
    
});
