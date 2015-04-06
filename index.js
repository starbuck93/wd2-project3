//server.js


// Require dependencies
var clients = [];
var app = require('http').createServer()
, fs = require('fs')
, io = require('socket.io').listen(app);

var usernames = {};
var rooms = ['Lobby'];
var people = 0;
// creating the server ( localhost:8000 )
app.listen(1234);
 io.sockets.on('connection', function(socket) {
  socket.on('username', function (data){ //call this with the $username var in php
        // socket.username = username;
        people += 1;
        console.log(people + " 1 join");
        socket.room = 'Lobby';         
        usernames[data.username] = data.username;
        socket.join('Lobby');          
        socket.emit('addUsername',{username: data.username, people: people  });
        socket.broadcast.to('Lobby').emit('onJoin', {people: people});
        socket.emit('onJoin', {people: people});
        if (people == 2) {
            socket.emit('startGame', {people: people});
        };
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
        people -= 1;
        console.log(people + " 1 leave");
        io.sockets.emit('updateusers', usernames);
        socket.broadcast.emit('updatechat', 'SERVER', socket.username + ' has disconnected');
        socket.leave(socket.room);
    });
 });