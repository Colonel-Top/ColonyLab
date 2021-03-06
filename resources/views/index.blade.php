<!doctype html>

<html lang="{{ app()->getLocale() }}">
    <head>
           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>P.K. Lab</title>
       
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>


.typewriter {
  overflow: hidden; /* Ensures the content is not revealed until the animation */
  border-right: .0001em  solid grey; /* The typwriter cursor 0015em*/
  white-space: nowrap; /* Keeps the content on a single line */
  margin: 0 auto; /* Gives that scrolling effect as the typing happens */
  letter-spacing: 1px; /* Adjust as needed */
  animation: 
    typing 1.6s steps(40, end),
    blink-caret .75s step-end infinite;
}

/* The typing effect */
@keyframes typing {
  from { width: 0 }
  to { width: 100% }
}

/* The typewriter cursor effect */
@keyframes blink-caret {
  from, to { border-color: transparent }
  50% { border-color: orange; }
}




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
 .site__title {

    font-size: 6rem;
    line-height: 1;
    color: #f35626;
    background-image: -webkit-linear-gradient(92deg,#f35626,#feab3a);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    -webkit-animation: hue 10s infinite linear;
    font-weight: 400;

  
  }
.bitun 
{
    color: #f35626;
    background-image: -webkit-linear-gradient(92deg,#f35626,#feab3a);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    -webkit-animation: hue 10s infinite linear;
    font-weight: 400;
}
.butt {
  border: 2px solid #f35626;
  line-height: 1.375;
  padding-left: 1.5rem;
  padding-right: 1.5rem;

  font-weight: 700;

  color: #f35626;

  cursor: pointer;
  -webkit-animation: hue 10s infinite linear;
  padding: .75rem;
    margin: .375rem;
    background-color: transparent;
    border-radius: 4px;
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
          @-webkit-keyframes hue {
  from {
    -webkit-filter: hue-rotate(0deg);
  }

  to {
    -webkit-filter: hue-rotate(-360deg);
  }
}

        </style>
      
    </head>
    <body>

    <div class = "fixed"><canvas id="c" width="1366" height="1366"></canvas></div>

<div class="flex-center position-ref full-height">
           
                <div class="top-right links">

                    <!--@auth
                        <a href="{{ url('/home') }}">Dashboard</a>
                    @else
                       <!  <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth -->
                    <a href="{{route('admin.login')}}">COL Panel</a>
                    <a href="{{route('aboutlab')}}">About Lab</a>
                    <a href="colonel-tech.com">Developer Site</a>
                </div>


            <div class="content">
                <div class="title m-b-md animated rubberBand">
                    <div class = "site__title ">
                    
                    P.K. lab
                        

                </div>
                </div>
                <div class = "midupdown semititle typewriter">
                    < Programming Kindle > <br> <br>Lab Practice System
                  
                    </div>
                  
                  
 <!--<div class ="semititle midupdown links"><a href="/admin">-</a></div>-->
                <div class="links entersite animated jello">
                @if(Auth::guest())
            
                 <a a href="/home"><button  class = "butt js--triggerAnimation" >Enter Site</button></a>
                 @else
                 <a a href="/home"><button  class = "butt js--triggerAnimation" >My Dashboard</button></a>
                 @endif
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
             matrix = " P P P "
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
        setInterval( draw, 42 );

        </script>
    </body>
</html>

