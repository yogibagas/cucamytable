
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
    <h1 class="error">CUCA MY TABLE SIGN UP</h1>
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
                @if(!$errors->isEmpty())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-warning" role="alert">
                        {{  $error }}
                        </div>
                    @endforeach
                @endif

                <h2> Sign Up Here </h2>
                <form method="POST" action="{{ route('register') }}">
                        @csrf
                    <div class="form-left-to-w3l">
                        <span class="fa fa-child" aria-hidden="true"></span>
                        <input type="text" name="name" placeholder=" Your Full Name" required="">

                        <div class="clear"></div>
                    </div>
                    <div class="form-left-to-w3l">
                        <span class="fa fa-user" aria-hidden="true"></span>
                        <input type="text" name="username" placeholder="Your Username (max 16 character)" required="">

                        <div class="clear"></div>
                    </div>
                    <div class="form-left-to-w3l">
                        <span class="fa fa-venus-mars" aria-hidden="true"></span>
                        <select name="gender" class="form-control">
                          <option value="">Choose your gender</option>
                        <option value="0">Male</option>
                      <option value="1">Female</option>
                        </select>

                        <div class="clear"></div>
                    </div>

                    <div class="form-left-to-w3l ">
                        <span class="fa fa-lock" aria-hidden="true"></span>
                        <input type="password" name="password" placeholder="Password ( Min 6 Character )" required="">

                        <div class="clear"></div>
                    </div>
                    <div class="form-left-to-w3l ">
                        <span class="fa fa-lock" aria-hidden="true"></span>
                        <input id="password-confirm" type="password" placeholder="Confirmation password" name="password_confirmation" required autocomplete="new-password">
                        <div class="clear"></div>
                    </div>

                    <div class="form-left-to-w3l">
                        <span class="fa fa-envelope-o" aria-hidden="true"></span>
                        <input type="email" name="email" placeholder="Email" required="">

                        <div class="clear"></div>
                    </div>
                    <div class="form-left-to-w3l">
                        <span class="fa fa-flag"></span>
                        <select name="country" class="form-control" id="country">
                            <option value="">Select your country</option>
                            @foreach($data as $country)
                            <option value="{{$country->id}}">{{$country->nicename}}</option>
                            @endforeach
                        </select>

                        <div class="clear"></div>
                    </div>
                    <div class="form-left-to-w3l">
                        <span class="" aria-hidden="true" id="code-text"><span class="fa fa-phone"></span></span>
                        <input type="text" name="phone" placeholder="Mobile Number" required="">

                        <div class="clear"></div>
                    </div>
                    <div class="btnn">
                        <button class="btn" type="submit">Sign Up </button>
                    </div>
                </form>
                <div class="w3layouts_more-buttn">
                    <h3>Already have an acccount?
                        <a href="{{route('login')}}">Login Here
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
            © <?= date('Y') ?> Cuca My Table Registration. All Rights Reserved
            <a href="https://cucabali.com" target="_blank">Cuca Bali</a>
        </p>
    </footer>
    <!-- script phone code -->

	<script type="text/javascript" src="{{url('js/jquery-2.2.3.min.js')}}"></script>
    <script>
    </script>
</body>

</html>
