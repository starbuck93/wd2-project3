


	var PhaserGame = function(game) {

		this.tank = null;
		this.cannon = null;
		this.bullet = null;

		this.background = null;
		this.land = null;

		this.power = 300;
		this.powerText = null;

		this.cursors = null;
		this.fireButton = null;

        this.move = true;
        this.ableToFire = false;
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

			this.land = this.add.sprite(0,game.world.height-64, "ground");
            this.land.scale.setTo(2,2);
            this.physics.arcade.enable(this.land);
            this.land.body.immovable = true;
            this.land.body.allowGravity = false;
            this.land.boundsPadding = 0;


			 //  A single bullet that the tank will fire
            this.bullet = this.add.sprite(0, 0, 'bullet');
            this.bullet.exists = false;
            this.physics.arcade.enable(this.bullet);



			this.tank = this.add.sprite(0,0, 'tank');
			// scales in precentages
			this.tank.scale.x = .05;
			this.tank.scale.y = .075;
            this.physics.arcade.enable(this.tank);
			this.tank.body.collideWorldBounds = true;
            this.tank.boundsPadding = 0;


			this.cannon = game.add.sprite(this.tank.x, this.tank.y, 'tank');
			
			this.cannon.scale.x = .06;
			this.cannon.scale.y = .02;

			 //  Used to display the power of the shot
            this.power = 300;
            this.powerText = this.add.text(8, 8, 'Power: 300', { font: "18px Arial", fill: "#ffffff" });
            this.powerText.setShadow(1, 1, 'rgba(0, 0, 0, 0.8)', 1);
            this.powerText.fixedToCamera = true;

            //  Some basic controls
            this.cursors = this.input.keyboard.createCursorKeys();
    
            this.fireButton = this.input.keyboard.addKey(Phaser.Keyboard.SPACEBAR);
            this.fireButton.onDown.add(this.switchB, this);	
		},

		bulletVsLand: function () {

            //  Simple bounds check
            if (this.bullet.x < 0 || this.bullet.x > this.game.world.width || this.bullet.y > this.game.height)
            {
                this.removeBullet();
                return;
            }

            /*var x = Math.floor(this.bullet.x);
            var y = Math.floor(this.bullet.y);
            var rgba = this.land.getPixel(x, y);

            if (rgba.a > 0)
            {
                this.land.blendDestinationOut();
                this.land.circle(x, y, 16, 'rgba(0, 0, 0, 255');
                this.land.blendReset();
                this.land.update();

                //  If you like you could combine the above 4 lines:
                // this.land.blendDestinationOut().circle(x, y, 16, 'rgba(0, 0, 0, 255').blendReset().update();

                this.removeBullet();
            }*/

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
            this.physics.arcade.velocityFromRotation(this.cannon.rotation, this.power, this.bullet.body.velocity);

        },

        /**
         * Removes the bullet, stops the camera following and tweens the camera back to the tank.
         * Have put this into its own method as it's called from several places.
         *
         * @method removeBullet
         */
        removeBullet: function (hasExploded) {

            if (typeof hasExploded === 'undefined') { hasExploded = false; }

            this.bullet.kill();
            this.camera.follow();

            var delay = 1000;

            if (hasExploded)
            {
                delay = 2000;
            }

            this.add.tween(this.camera).to( { x: 0 }, 1000, "Quint", true, delay);

        },

        switchB: function(){
            this.move = !this.move;
            this.ableToFire = !this.ableToFire;

            if(this.move)
                this.fire();
        },

        /**
         * Core update loop. Handles collision checks and player input.
         *
         * @method update
         */
        update: function () {

            this.cannon.x = this.tank.x+8;
            this.cannon.y = this.tank.y+5;



            this.physics.arcade.collide(this.land, this.tank);

            //  If the bullet is in flight we don't let them control anything
            if (this.bullet.exists)
            {

                //  Bullet vs. the land
                this.bulletVsLand();
            }
            else
            {
                if(this.move){

                    this.tank.body.velocity.x = 0;

                    if (this.cursors.left.isDown)
                    {
                        //  Move to the left
                        this.tank.body.velocity.x = -100;

                    }
                    if (this.cursors.right.isDown)
                    {
                        //  Move to the right
                        this.tank.body.velocity.x = 100;

                    }     
                    
                }
                if(this.ableToFire){
                    //  Allow them to set the power between 100 and 600
                    if (this.cursors.left.isDown && this.power > 100)
                    {
                        this.power -= 2;
                    }
                    else if (this.cursors.right.isDown && this.power < 600)
                    {
                        this.power += 2;
                    }

                    //  Allow them to set the angle, between -90 (straight up) and 0 (facing to the right)
                    if (this.cursors.up.isDown && this.cannon.angle > -90)
                    {
                        this.cannon.angle--;
                    }
                    else if (this.cursors.down.isDown && this.cannon.angle < 0)
                    {
                        this.cannon.angle++;
                    }

                    //  Update the text
                    this.powerText.text = 'Power: ' + this.power;
                }
            }

        }

    };