

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

  background-color: #4CAF50;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 22px;
  padding: 2px;
  
  transition: all 0.5s;
  cursor: pointer;

}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.8s;
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
        </style>
      
    </head>
    <body>

    <div class = "fixed"><canvas id="c" width="1366" height="1366"></canvas></div>

<div class="flex-center position-ref full-height">
            

            <div class="content">
                <div class="title m-b-md animated bounceInLeft">
                   Assignment
                </div>
                <div class="title m-b-md animated bounceInRight">
                    {{$asn->name}}
                </div>
                <div class = "midupdown semititle  animated jello">Max Attempts : {{$asn->max_attempts}}</div>
                <div class = "midupdown semititle">
                    <form action="{{ route('user.assignments.push') }}" method="POST" class="form-horizontal "enctype="multipart/form-data" >
                         {{ csrf_field() }} 
                 <input type="hidden" name="id" id="id" class="form-control" required value="{{$asn->id}}">
                <input class="field" id = "users_ans" name="users_ans" type="file" required>
                <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-10">
                            <input type="submit" class="btn btn-default animated rubberBand"  value="Upload Assignment" />
                        </div>
                    </div>
                </form>
                </div>
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

        </script>
    </body>
</html>

