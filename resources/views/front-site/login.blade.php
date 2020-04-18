
<!--A Design by W3layouts
   Author: W3layout
   Author URL: http://w3layouts.com
   License: Creative Commons Attribution 3.0 Unported
   License URL: http://creativecommons.org/licenses/by/3.0/
   -->
   <!DOCTYPE html>

<html lang="en">

<head>
    <title>Gadget Sign Up Form a Flat Responsive Widget Template :: w3layouts </title>
    <!-- Meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Gadget Sign Up Form Responsive Widget, Audio and Video players, Login Form Web Template, Flat Pricing Tables, Flat Drop-Downs, Sign-Up Web Templates, Flat Web Templates, Login Sign-up Responsive Web Template, Smartphone Compatible Web Template, Free Web Designs for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design"
    />
    <script>
        addEventListener("load", function () { setTimeout(hideURLbar, 0); }, false); function hideURLbar() { window.scrollTo(0, 1); }
    </script>
    <!-- Meta tags -->
    <!-- font-awesome icons -->
    <link href="{{url('css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- //font-awesome icons -->
    <!--stylesheets-->
    <link href="{{url('css/login-style.css')}}" rel='stylesheet' type='text/css' media="all">
    <link href="{{url('css/bootstrap.css')}}" rel='stylesheet' type='text/css' media="all">
    <!--//style sheet end here-->
    <link href="//fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
</head>
<body>
    <h1 class="error">CUCA MY TABLE LOGIN</h1>
	<!---728x90--->
    <div class="w3layouts-two-grids">
	<!---728x90--->
        <div class="mid-class">
            <div class="img-right-side">
                <h3>GET YOUR TABLE WITH OUR ONLINE RESERVATION</h3>
                <p>Make your life easier to get your table on our restaurant by doing reservation online on Cuca My Table</p>
                <img src="images/b11.png" class="img-fluid" alt="">
            </div>
            <div class="txt-left-side">
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>
            @endif
                @error('username')
                    <div class="alert alert-danger" role="alert">
                    {{ $message }}
                    </div>
                @enderror
                @error('password')
                    <div class="alert alert-danger" role="alert">
                    {{ $message }}
                    </div>
                @enderror
                <h2> Login Form </h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-left-to-w3l">
                        <span class="fa fa-user" aria-hidden="true"></span>
                        <input type="text" name="username" class=" @error('email') is-invalid @enderror" placeholder="Username" value="{{ old('username') }}" required autocomplete="email" autofocus required="">


                        <div class="clear"></div>
                    </div>
                    <div class="form-left-to-w3l">
                        <span class="fa fa-key" aria-hidden="true"></span>
                        <input type="password" placeholder="Password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        <div class="clear"></div>
                    </div>
                    <div class="btnn">
                        <button class="btn" type="submit">Login </button>
                    </div>
                </form>

                <div class="w3layouts_more-buttn">
                    <h3>Don't Have an account..?
                        <a href="{{route('register')}}">Register Here
                        </a>
                    </h3>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
	<!---728x90--->
    <footer class="copyrigh-wthree">
        <p>
            © 2019 CMY Sign Up Form. All Rights Reserved | Created by
            <a href="https://cucabali.com" target="_blank">Cuca Bali</a>
        </p>
    </footer>
</body>

</html>
