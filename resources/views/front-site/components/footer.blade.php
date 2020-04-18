
	<!--/foorer-->
	<!-- mail -->

	<!-- /contact -->
	<div class="copy">
		<p>&copy; {{date('Y')}} Cuca Bali. All rights reserved </a></p>

	</div>
	<!--/footer -->


	<!-- js -->
	<script type="text/javascript" src="{{url('js/jquery-2.2.3.min.js')}}"></script>
	<!-- //js -->
	<!--search-bar-->
	<script src="{{url('js/main.js')}}"></script>
	<!--//search-bar-->

	<!-- js for portfolio lightbox -->
	<script src="{{url('js/jquery.chocolat.js')}} "></script>
	<link rel="stylesheet " href="{{url('css/chocolat.css')}} " type="text/css" media="all" />
	<!--light-box-files -->
	<script type="text/javascript ">
		$(function () {
			$('.portfolio-grids a').Chocolat();
		});
	</script>
	<!-- /js for portfolio lightbox -->
	<!-- Calendar -->
	<link rel="stylesheet" href="{{url('css/jquery-ui.css')}}" />
	<script src="{{url('js/jquery-ui.js')}}"></script>
	<script>
		$(function () {
			$("#datepicker,#datepicker1,#datepicker2,#datepicker3").datepicker();
		});
	</script>
	<!-- //Calendar -->

	<!-- time -->
	<script type="text/javascript" src="{{url('js/wickedpicker.js')}}"></script>
	<script type="text/javascript">
		$('.timepicker').wickedpicker({
			twentyFour: false
		});
	</script>
	<!-- //time -->

	<script src="{{url('js/responsiveslides.min.js')}}"></script>
	<script>
		$(function () {
			$("#slider4").responsiveSlides({
				auto: true,
				pager: true,
				nav: true,
				speed: 1000,
				namespace: "callbacks",
				before: function () {
					$('.events').append("<li>before event fired.</li>");
				},
				after: function () {
					$('.events').append("<li>after event fired.</li>");
				}
			});
		});
	</script>
	<!-- script for responsive tabs -->
	<script src="{{url('js/easy-responsive-tabs.js')}}"></script>
	<script>
		$(document).ready(function () {
			$('#horizontalTab').easyResponsiveTabs({
				type: 'default', //Types: default, vertical, accordion
				width: 'auto', //auto or any width like 600px
				fit: true, // 100% fit in a container
				closed: 'accordion', // Start closed if in accordion view
				activate: function (event) { // Callback function if tab is switched
					var $tab = $(this);
					var $info = $('#tabInfo');
					var $name = $('span', $info);
					$name.text($tab.text());
					$info.show();
				}
			});
			$('#verticalTab').easyResponsiveTabs({
				type: 'vertical',
				width: 'auto',
				fit: true
			});
		});
	</script>
	<!--// script for responsive tabs -->
	<!-- start-smoth-scrolling -->
	<script type="text/javascript" src="{{url('js/move-top.js')}}"></script>
	<script type="text/javascript" src="{{url('js/easing.js')}}"></script>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$(".scroll").click(function (event) {
				event.preventDefault();
				$('html,body').animate({
					scrollTop: $(this.hash).offset().top
				}, 900);
			});
		});
	</script>
	<!-- start-smoth-scrolling -->

	<script type="text/javascript">
		$(document).ready(function () {
			/*
									var defaults = {
							  			containerID: 'toTop', // fading element id
										containerHoverID: 'toTopHover', // fading element hover id
										scrollSpeed: 1200,
										easingType: 'linear'
							 		};
									*/

			$().UItoTop({
				easingType: 'easeOutQuart'
			});

		});
	</script>
	<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	<script type="text/javascript" src="{{url('js/bootstrap-3.1.1.min.js')}}"></script>
@stack('scripts')

</body>

</html>
