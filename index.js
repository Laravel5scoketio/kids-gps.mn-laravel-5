var app = require('express')();

var server = require('http').Server(app);

var io = require('socket.io')(server);

server.listen(3000);

app.get('/', function(request, response) {
	response.sendFile(__dirname + '/index.html');
	// body...
});

io.on('connection', function(socket){


	socket.on('chat.message',function(name, message){

		console.log(name + message);
		io.emit('chat.message',name, message);

	});

	socket.on('gps.message',function(urt, urgun){

		// console.log(urt + urgun);
		io.emit('gps.message',urt, urgun);

	});


});