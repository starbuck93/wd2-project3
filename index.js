//server.js
// Require dependencies
var clients = [];
var app = require('http').createServer()
, fs = require('fs')
, io = require('socket.io').listen(app);

var usernames = {};
var people = 0;

app.listen(1234);
 io.sockets.on('connection', function(socket) {
  socket.on('username', function (data){ //call this with the $username var in php
        socket.username = data.username;
        usernames[data.username] = socket.id;
        people += 1;        
        console.log(people + " " + data.username + " join");
        if (people > 1) {
            socket.broadcast.emit('addUsername',{usernames: usernames, people: people  });
            socket.emit('addUsername',{usernames: usernames, people: people  });
            console.log(usernames)
            socket.emit('startGame', {people: people});
            socket.broadcast.emit('startGame', {people: people});
            console.log("Emmitted game start")
        };
    });
 	socket.on('hit', function(data) { //when a bullet hits a tank

    });
 	socket.on('move', function(data) { //when a tank moves, send it to the opponent
        // console.log(data)
        //                         player number or name,       left or right
        socket.emit('playerMove', {player: data.player, move: data.direction});

    });
 	socket.on('something', function(data) { //do stuff

    });
 	socket.on('gameOver', function(data) { //Post who the winner is!

    });

    socket.on('disconnect', function() {
        delete usernames[socket.username];
        console.log("people still in the game:",usernames);
        people -= 1;
        console.log(socket.username,"Left");
        socket.broadcast.emit('someoneLeft',{playerCount:people});
        people = 0;
    });
 });