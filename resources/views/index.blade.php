<!doctype html>

<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Colony Lab</title>

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
            }
.button {
    position: relative;
    background-color: #4CAF50;
    border: none;
    font-size: 28px;
    color: #FFFFFF;
    padding: 20px;
    width: 200px;
    text-align: center;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    text-decoration: none;
    overflow: hidden;
    cursor: pointer;
}

.button:after {
    content: "";
    background: #90EE90;
    display: block;
    position: absolute;
    padding-top: 300%;
    padding-left: 350%;
    margin-left: -20px!important;
    margin-top: -120%;
    opacity: 0;
    transition: all 0.8s
}

.button:active:after {
    padding: 0;
    margin: 0;
    opacity: 1;
    transition: 0s
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
                color:#C2C2C2;
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
        </style>
      
    </head>
    <body>

    <div class = "fixed"><canvas id="c" width="1366" height="1366"></canvas></div>

<div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Dashboard</a>
                    @else
                       <!--  <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a> -->
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Colony lab
                </div>
                <div class = "midupdown semititle">Coding Lab Practice System<div class =links><a href="/admin">-</a></div></div>

                <div class="links entersite">

                 <a href="/home">Enter Site</a>
                </div>
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
        var matrix = "♥  ";
        switch (rand)
        {
            case 2:
                matrix =" C N 3 0 2 0 ";
                break;
            case 1:
             
            matrix = "C O L O N E L";
            break;
            case 3:
             matrix = " P I N  "
             break;
            default:
            matrix = "♥   ";
             break;
        }
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

            ctx.fillStyle = "#FFFFFF"; //green text
            ///ctx.fillStyle = "#0F0"; //green text
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

        </script>
    </body>
</html>

