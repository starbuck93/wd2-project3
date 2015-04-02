//server.js

// Require dependencies
var clients = [];
var app = require('http').createServer()
, fs = require('fs')
, io = require('socket.io').listen(app);

var usernames = {};
var rooms = ['Lobby'];
// creating the server ( localhost:8000 )
app.listen(1234);
 io.sockets.on('connection', function(socket) {
  socket.on('adduser', function (username){ //call this with the $username var in php

    });
 	socket.on('create', function(room) { //one room means 2 people playing a single game
        rooms.push(room);
        socket.emit('updaterooms', rooms, socket.room);
    });
 	socket.on('hit', function(data) { //when a bullet hits a tank
        
    });
 	socket.on('move', function(data) { //when a tank moves, send it to the opponent
        
    });
 	socket.on('something', function(data) { //do stuff
        
    });
 	socket.on('gameOver', function(data) { //Post who the winner is!
        
    });

    socket.on('disconnect', function() {
        delete usernames[socket.username];
        io.sockets.emit('updateusers', usernames);
        socket.broadcast.emit('updatechat', 'SERVER', socket.username + ' has disconnected');
        socket.leave(socket.room);
    });
 });