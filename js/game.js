
var socket = io('http://wd2.starbuckstech.com:1234');
var username = '';

socket.on('addUsername', function (data) {
  console.log(data.username + " " + data.people);
  username = data.username + data.people;
});

socket.on('gameStart', function () {
	console.log("blee");
});


   var player;
   var playerNum = 1;
   var ground;
   var flagWaiting = true;

socket.on('onJoin', function (data) {
  console.log(data);
  if (data.people > 1) {
  	flagWaiting = false;
  };
  console.log(flagWaiting);
  
});

    var Tank = function(index, game){
        this.cursor = {
            left:false,
            right:false,
            up:false,
            down:false
        }

        this.input = {
            left:false,
            right:false,
            up:false,
            down:false
        }

        this.username = username;

        this.game = game;
        this.move = true;
        this.ableToFire = false;

        this.id = index;
         //  A single bullet that the tank will fire
        this.bullet = game.add.sprite(0, 0, 'bullet');
        this.bullet.exists = false;
        game.physics.arcade.enable(this.bullet);



        this.tank = game.add.sprite(0,0, 'tank');
        // scales in precentages
        this.tank.scale.x = .05;
        this.tank.scale.y = .075;
        game.physics.arcade.enable(this.tank);
        this.tank.body.collideWorldBounds = true;
        this.tank.boundsPadding = 0;


        this.cannon = game.add.sprite(this.tank.x, this.tank.y, 'tank');
        
        this.cannon.scale.x = .06;
        this.cannon.scale.y = .02;

        this.power = 300;
    }

    Tank.prototype = {

        bulletVsLand: function () {

            //  Simple bounds check
            if (this.bullet.x < 0 || this.bullet.x > this.game.world.width || this.bullet.y > this.game.height)
            {
                this.removeBullet();
                return;
            }
        },

        fire: function () {

            if (this.bullet.exists)
            {
                return;
            }

            //  Re-position the bullet where the cannon is
            this.bullet.reset(this.cannon.x, this.cannon.y);

            //  Now work out where the END of the cannon is
            var p = new Phaser.Point(this.cannon.x, this.cannon.y);
            p.rotate(p.x, p.y, this.cannon.rotation, false, 34);


            //  Our launch trajectory is based on the angle of the cannon and the power
            this.game.physics.arcade.velocityFromRotation(this.cannon.rotation, this.power, this.bullet.body.velocity);

        },

        removeBullet: function () {

            this.bullet.kill();
        },

        switchB: function(){
            this.move = !this.move;
            this.ableToFire = !this.ableToFire;

            if(this.move)
                player.fire();
        },

        /**
         * Core update loop. Handles collision checks and player input.
         *
         * @method update
         */

        update: function(){

            this.cannon.x = this.tank.x+8;
            this.cannon.y = this.tank.y+5;



            game.physics.arcade.collide(ground, this.tank);


            function checkMove(thing){
                socket.on('playerMove', function (data) {
                    console.log(data);
                    //{player: data.player, move: data.direction}
                    if (data.player == 1 && data.move == "left") { //  Move to the left
                        thing.tank.body.velocity.x = -100;
                    }
                    else if (data.player == 1 && data.move == "right") { //  Move to the right
                        thing.tank.body.velocity.x = 100;
                    }
                    else this.tank.body.velocity.x = 0;
                });

            }

            //  If the bullet is in flight we don't let them control anything
            if (this.bullet.exists)
            {
                //  Bullet vs. the land
                this.bulletVsLand();
            }
            else
            {
                if(this.move){
                    if (this.cursor.left)
                    {
                        //  Move to the left
                        socket.emit('move', {player: playerNum, direction: "left"});
                    }
                    if (this.cursor.right)
                    {
                        //  Move to the right
                        socket.emit('move', {player: playerNum, direction: "right"});
                    }
                    checkMove(this);  
                }
                if(this.ableToFire){
                    //  Allow them to set the power between 100 and 600
                    if (this.cursor.left && this.power > 100)
                    {
                        this.power -= 2;
                    }
                    else if (this.cursor.right && this.power < 600)
                    {
                        this.power += 2;
                    }
                    //  Allow them to set the angle, between -90 (straight up) and 0 (facing to the right)
                    else if (this.cursor.up && this.cannon.angle > -179)
                    {
                        this.cannon.angle--;
                    }
                    else if (this.cursor.down && this.cannon.angle < 0)
                    {
                        this.cannon.angle++;
                    }
                }
            }
        }
    };

    var menu = function(game){
        this.background = null;
        this.ground = null;
        this.startB = null;
        this.click = null;
    };

    menu.prototype = {

        preload: function(){

            this.load.image('background', 'images/menuBackground.jpg');
            this.load.image('startButton', 'images/startButton.png');

        },

        create: function(){

            this.background = this.add.sprite(0,0, 'background');


            // this.startB = this.game.add.button(this.game.width/2, this.game.height/2, 'startButton', this.startClick, this);
            // this.startB.anchor.setTo(0.5,0.5);

            this.waitingText = this.add.text(8, 40, 'Waiting for more players... Have one of your friends join', { font: "18px Arial", fill: "#ffffff" });
            this.waitingText.setShadow(1, 1, 'rgba(0, 0, 0, 0.8)', 1);
            this.waitingText.fixedToCamera = true;


        },

        // startClick: function(){

        //     this.game.state.start('play');
        // }
    };

	

    var PhaserGame = function(game) {

		this.game = game;

		this.background = null;

		this.power = 300;
		this.powerText = null;

		this.cursors = null;
		this.fireButton = null;

	};

	PhaserGame.prototype = {

		init: function () {


            this.game.renderer.renderSession.roundPixels = true;


            this.physics.startSystem(Phaser.Physics.ARCADE);
            this.physics.arcade.gravity.y = 200;

        },

		preload: function(){

			this.load.image('sky', 'images/sky.png');
			this.load.image('ground', 'images/platform.png');
			this.load.image('tank', 'images/rec.jpg');
			this.load.image('bullet', 'images/bullet.png');
            this.load.image('land', 'images/land.png');
		},


		create: function(){

			this.background = this.add.sprite(0,0, 'sky');

			ground = this.add.sprite(0,game.world.height-64, "ground");
            ground.scale.setTo(2,2);
            this.physics.arcade.enable(ground);
            ground.body.immovable = true;
            ground.body.allowGravity = false;
            ground.boundsPadding = 0;

            player = new Tank(0, this);
            // player2 = new Tank(1, this);
            // player2.position = (100,60);

            //  Used to display the power of the shot
            this.power = player.power;
            this.powerText = this.add.text(8, 8, 'Power: 300', { font: "18px Arial", fill: "#ffffff" });
            this.powerText.setShadow(1, 1, 'rgba(0, 0, 0, 0.8)', 1);
            this.powerText.fixedToCamera = true;

			this.username = this.add.text(550, 8, player.username, { font: "18px Arial", fill: "#ffffff" });
            this.username.setShadow(1, 1, 'rgba(0, 0, 0, 0.8)', 1);
            this.username.fixedToCamera = true;
            this.username.align="right";


            //  Some basic controls
            this.cursors = this.input.keyboard.createCursorKeys();
			
            this.fireButton = this.input.keyboard.addKey(Phaser.Keyboard.SPACEBAR);
            this.fireButton.onDown.add(player.switchB, player);
		},

		
        update: function () {

        	// if (!flagWaiting) {
        	// 	game.world.remove(this.waitingText);
        	// }

            player.cursor.left = this.cursors.left.isDown;
            player.cursor.right = this.cursors.right.isDown;
            player.cursor.up = this.cursors.up.isDown;
            player.cursor.down = this.cursors.down.isDown;

            player.update();
            // player2.update();

            //  Update the text
            this.powerText.text = 'Power: ' + player.power;

        }

    };
