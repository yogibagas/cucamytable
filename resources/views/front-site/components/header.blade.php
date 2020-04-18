
<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>

<head>
	<title>@yield('page_title', 'Cuca My Table')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="keywords" content="Cuca Reservation" />

	<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<link href="{{url('css/bootstrap.css')}}" rel='stylesheet' type='text/css' />
	<link href="{{url('css/wickedpicker.css')}}" rel="stylesheet" type='text/css' media="all" />
	<link href="{{url('css/easy-responsive-tabs.css')}}" rel='stylesheet' type='text/css' />
	<link href="{{url('css/style.css')}}" rel='stylesheet' type='text/css' />
	<link href="{{url('css/font-awesome.css')}}" rel="stylesheet">
	<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
	    rel='stylesheet' type='text/css'>
</head>

<body>
	<!--Header-->
	<div class="header" id="home">
		<!--/top-bar-->
		<div class="top-bar">
			<div class="header-top_w3layouts">
				<div class="forms">
					<p><span class="fa fa-map-marker" aria-hidden="true"></span>Jalan Yoga Perkanthi, Jimbaran - Bali Indonesia</p>
					<p><span class="fa fa-envelope-o" aria-hidden="true"></span> <a href="mailto:info@example.com">family@cucabali.com</a></p>
				</div>
				<ul class="top-right-info">
					<a href="/panel" class="text-white">Make a reservation <i class="fa fa-caret-right"></i></a>
							@if (Auth::user())
							<li class="dropdown menu__item">
							<a href="#" class="dropdown-toggle text-white menu__link" data-toggle="dropdown" ><i class="fa fa-user" aria-hidden="true"></i> <b>{{Auth::user()->username}} <span class="fa fa-angle-down"></span></b></a>
									<ul class="dropdown-menu">
										<li><a class="" href="/panel">Panel Area</a></li>
										<li><a class="" href="/panel/reservation/list">My Reservation</a></li>
										<li><a class="" href="/panel/badge/collection">My Badges</a></li>
										<li><a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a></li>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
									</ul>
								</li>
							@else
							<li class="login-list-w3ls">
								<a href="{{route('login')}}" class="text-white"><i class="fa fa-user" aria-hidden="true"></i> Login</a>
							</li>
							@endif

				</ul>

				<div class="search">
					<div class="cd-main-header">
						<ul class="cd-header-buttons">
							<li><a class="" href="#cd-search"> <span></span></a></li>
						</ul>
						<!-- cd-header-buttons -->
					</div>
					<!-- <div id="cd-search" class="cd-search">
						<form action="#" method="post">
							<input name="Search" type="search" placeholder="Click enter after typing...">
						</form>
					</div>-->
				</div>
				<div class="clearfix"></div>

			</div>
			<div class="header-nav">
				<nav class="navbar navbar-default">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
						<a class="navbar-brand" href="{{url("/")}}">
							<img src="{{url('/images/Cuca_logo-2.png')}}" class="img logo img-responsive">
						</a>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
						<nav>
							<ul class="top_nav">
								<li><a class="scroll" href="#home" class="active">Home</a></li>

									<li><a class="scroll" href="#menu" class="active">Menu</a></li>
									@if(Auth::user())
										<li><a class="" href="/panel/leaderboards" class="active">Leaderboards</a></li>
										@endif
								<li class="reservation-btn">
									<a class="" href="/panel/reservation/create">Get a Table</a>
								</li>
							</ul>
						</nav>
					</div>
				</nav>

			</div>
		</div>
			<!--//top-bar-->
		<!-- banner-text -->
		<div class="slider">
			<div class="callbacks_container">
				<ul class="rslides callbacks callbacks1" id="slider4">
					<li>
						<div class="banner-top">
							<div class="banner-info_agile_w3ls">
								<h3>Come hungry. <span>Leave</span> happy.</h3>
								<p>Small change,Big differences.</p>
								<a href="{{url('/panel/reservation/create')}}" class="">Get your table <i class="fa fa-caret-right" aria-hidden="true"></i></a>
							</div>

						</div>
					</li>
					<li>
						<div class="banner-top1">
							<div class="banner-info_agile_w3ls">
								<h3>Better Ingredients. <span> Better</span> Food.</h3>
								<p>Small change,Big differences.</p>
								<a href="{{url('/panel/reservation/create')}}" class="">Get your table <i class="fa fa-caret-right" aria-hidden="true"></i></a>

							</div>

						</div>
					</li>
					<li>
						<div class="banner-top2">
							<div class="banner-info_agile_w3ls">
								<h3>Come hungry. <span>Leave</span> happy.</h3>
								<p>Small change,Big differences.</p>
								<a href="{{url('/panel/reservation/create')}}" class="">Get your table <i class="fa fa-caret-right" aria-hidden="true"></i></a>
							</div>

						</div>
					</li>
					<li>
						<div class="banner-top3">
							<div class="banner-info_agile_w3ls">
								<h3>Better Ingredients. <span> Better</span> Food.</h3>
								<p>Small change,Big differences.</p>
								<a href="{{url('/panel/reservation/create')}}" class="">Get your table <i class="fa fa-caret-right" aria-hidden="true"></i></a>
							</div>

						</div>
					</li>
				</ul>
			</div>
			<div class="clearfix"> </div>

			<!--banner Slider starts Here-->
		</div>
		<!-- //Modal1 -->
		<!--//Slider-->
	</div>
	<!--//Header-->
