
<!DOCTYPE html>
<html>
<head>
	<title>Reservation Confirmation</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Creative coming soon Widget Responsive, Login form web template,Flat Pricing tables,Flat Drop downs  Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!--online_fonts-->
	<link href="//fonts.googleapis.com/css?family=Pacifico&amp;subset=latin-ext" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Poiret+One&amp;subset=cyrillic,latin-ext" rel="stylesheet">
	<!--//online_fonts-->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="{{url('js/confirmation/js/jquery.min.js')}}"></script>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- stylesheet-->
	<link rel="stylesheet" href="{{url('css/confirmation/font-awesome.min.css')}}" /><!--font_awesome_icons-->
	<link rel="stylesheet" href="{{url('css/confirmation/jquery.countdown.css')}}" />
	<link href="{{url('css/confirmation/style.css')}}" rel='stylesheet' type='text/css' media="all" /><!--stylesheet-->
<!--/stylesheet-->
</head>
<body>
<!--main-->
@if($reservation->payment_status == 0)
<div class="main-agile" style="text-align:center;">
<div class="right-w3ls" style="text-align:center;">
		<img src="{{url('images/Cuca_logo-2.png')}}" style="text-align:center;"><br><br>
		<h3 style="margin-top:15px">Reservation Confirmed, We are ready to serve you on</h3>
	<!--timer-->
	<div class="agileits-timer">
		<div class="clock">
			<div class="column">
				<div class="timer" id="hours">{{\Carbon\Carbon::parse($reservation->reservation_datetime)->format('d')}}</div>
				<div class="text"></div>
			</div>
			<div class="timer"></div>
			<div class="column">
				<div class="timer" id="minutes">{{\Carbon\Carbon::parse($reservation->reservation_datetime)->format('F')}}</div>
				<div class="text">{{\Carbon\Carbon::parse($reservation->reservation_datetime)->format('H:i:s')}}</div>
			</div>
			<div class="timer"></div>
			<div class="column">
				<div class="timer" id="seconds">{{\Carbon\Carbon::parse($reservation->reservation_datetime)->format('Y')}}</div>
				<div class="text"></div>
			</div>
			<div class="clear"> </div>
		</div>
	</div>
	<!--//timer-->
	<br><br><br>
		<div class="newsletter">
		</div>
</div>
<div class="clear"> </div>
<!--copyright-->
	<a href="{{'https://cuca-table.test/panel/reservation/'.$reservation->reservation_code.'/summary'}}" style="background:#FFF;padding:15px;color:#AF8A5C;">See My Reservation</a>
	<div class="copy w3ls">
	   <p>&copy; 2020 Cuca Bali </p>
	</div>
<!--//copyright-->
</div>

<!--main-->
@else
Your payment failed please wait , we will redirect you to our site if this page not redirect <a href="https://cuca-table.test/">click here</a> , we will bring you back.
<script type="text/JavaScript">
      setTimeout("location.href = 'https://cuca-table.test/';",1500);
 </script>
@endif
<!--scripts-->
	<!-- <script type="text/javascript" src=" {{url('js/confirmation/js/moment.js')}}"></script>
	<script type="text/javascript" src=" {{url('js/confirmation/js/moment-timezone-with-data.js')}}"></script>
	<script type="text/javascript" src="{{url('js/confirmation/js/timer.js')}}"></script> -->
<!--//scripts-->
<script></script>
</body>
</html>
