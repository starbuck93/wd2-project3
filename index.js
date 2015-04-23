//server.js


// Require dependencies
var clients = [];
var app = require('http').createServer()
, fs = require('fs')
, io = require('socket.io').listen(app);

var usernames = {};
var rooms = ['Lobby'];
var people = 0;
var players = {};
// creating the server ( localhost:8000 )
app.listen(1234);
 io.sockets.on('connection', function(socket) {
  socket.on('username', function (data){ //call this with the $username var in php
        // socket.username = username;
        people += 1;
        console.log(people + " " + data.username + " join");
        socket.room = 'Lobby';         
        usernames[data.username] = data.username;
        players[people] = data.username
        socket.join('Lobby');          
        socket.emit('addUsername',{username: data.username, people: people  });
        socket.broadcast.to('Lobby').emit('onJoin', {people: people});
        socket.emit('onJoin', {people: people});
        if (people > 1) {
            socket.emit('startGame', {people: people});
        };
    });
 	socket.on('hit', function(data) { //when a bullet hits a tank

    });
 	socket.on('move', function(data) { //when a tank moves, send it to the opponent
        console.log(data)
        //                         player number or name,       left or right
        socket.emit('playerMove', {player: data.player, move: data.direction});

    });
 	socket.on('something', function(data) { //do stuff

    });
 	socket.on('gameOver', function(data) { //Post who the winner is!

    });

    socket.on('disconnect', function() {
        people -= 1;
        console.log(people + " leave");
        io.sockets.emit('updateusers', usernames);
        socket.leave(socket.room);
    });
 });