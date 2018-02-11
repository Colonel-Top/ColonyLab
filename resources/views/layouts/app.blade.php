<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <style>


    /*Maple Story*/

    body {
                background-color: #D4D4D8;
                background-color: #f5f8fa;
               /* padding: 30px;
                margin: 0px;*/
            }
            #mapleleafContainer {
                position: absolute;
                left: 0px;
                top: 0px;
            }
            .mapleleaf {
                padding-left: 10px;
                font-family: Tahoma,serif;
                font-size: 10px;
                line-height: 20px;
                position: fixed;
               /*color:#C13E30;*/
               color:#EDD;
                user-select: none;
                z-index: 1000;

            }
            #snowflakeContainer {
                position: absolute;
                left: 0px;
                top: 0px;
            }
            .snowflake {
                padding-left: 15px;
                font-family: Cambria, Georgia, serif;
                font-size: 14px;
                line-height: 24px;
                position: fixed;
                color: #10101021;
                /*color: #ffffff08;*/
                user-select: none;
                z-index: 1000;
            }
            .snowflake:hover {
                cursor: default;
                
            }
            p,  {
                font-family: "Franklin Gothic Medium", "Arial Narrow", sans-serif;
                font-size: 24px;
                color: #CCC;

            }


    /* Maple plz */



        .centers
        {
            padding-right: 20px;
        }
        .footer-distributed{
            background-color: #292c2f;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.12);
            box-sizing: border-box;
            width: 100%;
            text-align: left;
            font: normal 16px sans-serif;

            padding: 21px 50px;
            margin-top: 400px;


            position: static;
    left: 0;
    bottom: 0;
    width: 100%;
        }

        .footer-distributed .footer-left p{
            color:  #8f9296;
            font-size: 14px;
            margin: 0;
        }

        /* Footer links */

        .footer-distributed p.footer-links{
            font-size:18px;
            font-weight: bold;
            color:  #ffffff;
            margin: 0 0 10px;
            padding: 0;
        }
        .boldandwhiteplz
        {
            color: #ffffff;
            font-weight: bold;
        }
        .footer-distributed p.footer-links a{
            display:inline-block;
            line-height: 1.8;
            text-decoration: none;
            color:  inherit;
        }

        .footer-distributed .footer-right{
            float: right;
            margin-top: 6px;
            max-width: 180px;
        }

        .footer-distributed .footer-right a{
            display: inline-block;
            width: 35px;
            height: 35px;
            background-color:  #33383b;
            border-radius: 2px;

            font-size: 20px;
            color: #ffffff;
            text-align: center;
            line-height: 35px;
            padding-top: 7px;
            margin-left: 3px;
        }

        /* If you don't want the footer to be responsive, remove these media queries */

        @media (max-width: 600px) {

            .footer-distributed .footer-left,
            .footer-distributed .footer-right{
                text-align: center;
            }

            .footer-distributed .footer-right{
                float: none;
                margin: 0 auto 20px;
            }

            .footer-distributed .footer-left p.footer-links{
                line-height: 1.8;
            }
        }



.newbg{
  
    background-image: url(http://www.sngmi.com/wp-content/uploads/2015/10/background-mountain.jpg);
    background-size: cover;
      -webkit-filter: blur(5px);


}

    </style>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body >
<div class = "newbg">

  
</div>
    <div id="app" >
        <nav class="navbar navbar-inverse navbar-static-top boldandwhiteplz">
            <div class="container ">
                  <p class="snowflake">
                <!--📌 -->
                *
            </p>
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand animated infinite pulse" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right animated lightSpeedIn">
                        <!-- Authentication Links -->
                        @if(Auth::guest())

                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                     
                            
                        @elseif(Auth::guard('admin')->check())
                           
                                <li class>
                                    <a href="{{route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li >
                                    <a href="{{route('admin.courses.index')}}">Courses Manager</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.remarks.pickmode')}}">Remarks Management</a>
                                </li>
                                <li class = "dropdown">

                                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                   Account Management 
                                    </a>
                                    <ul class ="dropdown-menu">
                                    <li>  
                                     <a href="{{route('admin.register.show')}}">Assign New Administrator</a>
                                     <a href = "{{route('admin.usercontrol')}}">Users Management</a>
                                    </li>
                                    </ul>
                                </li>

                          <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>@if(Auth::guard('admin')->check())
                                        <a href="{{ route('admin.profile.request') }}"">
                                            Edit Profile
                                        </a>
                                        @else
                                            <a href="{{ route('user.profile.request') }}"">
                                            Edit Profile
                                        </a>
                                        @endif
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                                
                                <li class>
                                    <a href="{{route('dashboard')}}">Dashboard</a>
                                </li>
                                <li >
                                    <a href="{{route('user.courses.index')}}">Courses List</a>
                                </li>
                                <li >
                                    <a href="{{route('user.courses.my')}}">My Courses</a>
                                </li>
                                <li>
                                    
                                <li>
                                    <a href="{{route('user.grades.getcourse')}}">Remarks</a>
                                </li>
                                <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('user.profile.request') }}"">
                                            Edit Profile
                                        </a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                         
                       
                         
                        @endguest
                    </ul>
                </div>

            </div>
        </nav>

        @yield('content')
         
    </div>



    <!-- Scripts -->

         <script src="//www.kirupa.com/js/fallingsnow_v6.js"></script>
        <script src="//www.kirupa.com/js/prefixfree.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
     <footer class="footer-distributed">

            <div class="footer-right">

                <a href="https://www.facebook.com/colonel.pp"><i class="fa fa-facebook"></i></a>
                <!--<a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>-->
                <a href="https://github.com/Colonel-Top"><i class="fa fa-github"></i></a>
                <a href="{{ url('/') }}"><i class="fa fa-home"></i></a>
                
            </div>
            
            <div class="footer-left">

                <p class="footer-links">
                    <a href="{{ url('/') }}">Home</a>
                    ·
                    <a href="{{route('aboutlab')}}">About Lab</a>
                    ·
                  <!--<a href="#">Contact Developer</a>-->
                </p>

                <p>Colonel Technology &copy; 2018 : Under International Law Agreement</p>
            </div>

        </footer>
        
</body>
</html>
