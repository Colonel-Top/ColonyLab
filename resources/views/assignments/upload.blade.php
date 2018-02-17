

<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Upload Assignment {{$asn->name}}</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
               
                color: ##C2C2C2;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

  

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .semititle{
                font-size: 30px;
                color:#00000;
                font-weight: 600;
            }

            .midupdown
            {
                margin-top: 20px;
                margin-bottom: 20px;
            }
            .entersite
            {
                margin-top: 100px;
                font-size: 22px;
                color:#00000;
                font-weight: 600;
            }
           .button {
  display: inline-block;
  border-radius: 4px;
  background-color: #1ef49b;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 28px;
  padding: 20px;
  width: 200px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .fixed
            {
                position: fixed;
                color:#fff;
                background: white;
                opacity:0.21;
            }
          
            .m-b-md {
                margin-bottom: 30px;
            }







             { -webkit-box-sizing: border-box; box-sizing: border-box; }

html, body {
    height: 100%;
  background: @color-dark;
}

.hwa() {
    -webkit-transform: translate3d(0, 0, 0);
    -moz-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
}

@color-dark: #151515;
@color-grey: #858484;
@color-gold: #e5e2d9;
@color-brown: #a7a190;

#pagetransition {
    position: fixed;
    top: 0;
    z-index: 999;
    width: 100%;
    height: 100%;
    .hwa();
}

#bg {
    position: fixed;
    top: 0;
    z-index: 1;
    width: 100%;
    height: 100%;
    background: url(http://voice-vic.cust.good-morning.no/wp-content/uploads/2013/05/03U0096.jpg) no-repeat center center fixed;
    background-size: cover;

}

.square {
  position: absolute;
  width: 100%;
  height: 100%;
  .hwa();
}

.square.black {
  background: @color-dark;
  top: -50%;
  left: -20%;
  z-index: 3;
}

.square.white {
  background: #fff;
  height: 200%;
  right: -50%;
  top: -130%;
  z-index: 5;
}

.square.gold {
  background: @color-gold;
  right: -20%;
  bottom: -50%;
  z-index: 4;
}

.square.grey {
  background: @color-grey;
  height: 200%;
  left: -50%;
  bottom: -130%;
  z-index: 4;
}

.vic-gb {
    position: fixed;
    top: 50%;
    left: 50%;
  margin-top: -196px/2;
  margin-left: -287px/2;
    z-index: 999;
    width: 287px;
    height: 196px;
    background: url(https://s.cdpn.io/40480/vic-gathering-brands-emblem.png) ;

}
        </style>
      
    </head>
    <body>
        <div id="pagetransition">
  <div class="square black"></div>
  <div class="square white"></div>
  <div class="square gold"></div>
  <div class="square grey"></div>
  
  <div class="vic-gb"></div>
</div>

<div id="bg"></div>

    <div class = "fixed"><canvas id="c" width="1366" height="1366"></canvas></div>

<div class="flex-center position-ref full-height">
            

            <div class="content">
                <div class="title m-b-md animated bounceInLeft">
                   Assignment
                </div>
                <div class="title m-b-md animated bounceInRight">
                    {{$asn->name}}
                </div>
                @if($asn->max_attempts != 0)
                <div class = "midupdown semititle  animated jello">Oops Limited Max Attempts : {{$asn->max_attempts}}</div>
                @else
                <div class = "midupdown semititle  animated jello"></div>
                @endif
                <div class = "midupdown semititle">
                    <form action="{{ route('user.assignments.push') }}" method="POST" class="form-horizontal "enctype="multipart/form-data" >
                         {{ csrf_field() }} 
                 <input type="hidden" name="id" id="id" class="form-control" required value="{{$asn->id}}">
                 <br>
                <input class="field" id = "users_ans" name="users_ans" type="file" required>
                <div class="form-group">
                    <br>
                        <div class="col-sm-offset-3 col-sm-10">
                            <input type="submit" class="btn btn-default animated rubberBand"  value="Upload Assignment" />
                        </div>
                    </div>
                </form>
                </div>
                <button class="button" style="vertical-align:middle" >
                <a href="{{ route('user.assignments.indexmy',$courseid) }}"><span> Go Back  </span></button></a>
              <!--  <a class="button" href="{{ route('user.assignments.push',$asn->id) }} "><span> Upload Assignment </span></button>-->

            </div>

        </div>




        

 <script>
        // geting canvas by id c
        var c = document.getElementById("c");
        var ctx = c.getContext("2d");
       // ctx.background : #000;
        //making the canvas full screen
        c.height = window.innerHeight;
        c.width = window.innerWidth;
        //chinese characters - taken from the unicode charset
        var rand = Math.floor((Math.random() * 5) + 1);
        var matrix = "♥   A   ♥   A";
      
        //var matrix = "COLONEL CN302 0     ";
        
        //converting the string into an array of single characters
        matrix = matrix.split("");

        var font_size = 10;
        var columns = c.width / font_size; //number of columns for the rain
        //an array of drops - one per column
        var drops = [];
        //x below is the x coordinate
        //1 = y co-ordinate of the drop(same for every drop initially)
        for(var x = 0; x < columns; x++)
            drops[x] = 1; 

        //drawing the characters
        function draw()
        {
            //Black BG for the canvas
            //translucent BG to show trail
            ctx.fillStyle = "rgba(0, 0, 0, 0.2)";
            ctx.fillRect(0, 0, c.width, c.height);

            //ctx.fillStyle = "#FFFFFF"; //green text
            ctx.fillStyle = "#0F0"; //green text
            ctx.font = font_size + "px arial";
            //looping over drops
            for( var i = 0; i < drops.length; i++ )
            {
                //a random chinese character to print
                var text = matrix[ Math.floor( Math.random() * matrix.length ) ];
                //x = i*font_size, y = value of drops[i]*font_size
                ctx.fillText(text, i * font_size, drops[i] * font_size);

                //sending the drop back to the top randomly after it has crossed the screen
                //adding a randomness to the reset to make the drops scattered on the Y axis
                if( drops[i] * font_size > c.height && Math.random() > 0.975 )
                    drops[i] = 0;

                //incrementing Y coordinate
                drops[i]++;
            }
        }

        //setInterval( draw, 35 );
        setInterval( draw, 44 );




var config = {}; 
config.window = $(window);
config.wWidth = config.window.width();
config.wHeight = config.window.height();

config.t = 1;
config.t2 = 3;
config.e = Power2.easeOut;
config.e2 = Power2.easeIn;

config.pageTrans = new TimelineMax({repeat:-1, repeatDelay: 0, yoyo:true});

config.pageTrans
.fromTo('.white',config.t, { x: config.wWidth/2 }, { x: 0, ease: config.e}, "f")
.fromTo('.grey',config.t, { x: -config.wWidth/2 }, { x: 0, ease: config.e}, "f")
.fromTo('.black',config.t, { y: -config.wHeight }, { y: 0, ease: config.e}, "f")
.fromTo('.gold',config.t, { y: config.wHeight }, { y: 0, ease: config.e}, "f")
.fromTo('.grey', config.t2, { y: 0 }, { y: -config.wHeight/2, ease: config.e2}, "f+=.8")
.fromTo('.white', config.t2, { y: 0 }, { y: config.wHeight/2, ease: config.e2}, "f+=.8")
.fromTo('#pagetransition', 2.5, { rotation: 0 }, { rotation: 10, ease: config.e}, "f")
.fromTo('.vic-gb', .8, { rotation: 0, scale: 0 }, { rotation: -10, scale: 1, ease: Back.easeOut}, "f+=.6")

        </script>
    </body>
</html>

