@extends('front-site/layouts/page')
@section('page_title')
Cuca My Table
@endsection
@section('content')

	<div class="news" id="about">
		<div class="container">
			<div class="news-main_wthree_agile">
				<div class="col-md-6 news-left">
					<h2>CUCA BALI CONCEPT</h2>
				</div>
				<div class="col-md-6 news-right">
					<p>Expect a casual experience both in feel and pricing and totally focused on food: we save on luxurious tableware and never compromise on quality. Our restaurant offers small portions so you can try more and a unique signature menu meant to be shared.

We start by getting the basics right: the most amazing ingredients carefully selected for our restaurant and sourced exclusively from Indonesia to maximize freshness, support local farmers and growers and showcase the uniqueness of delicious local products.
					</p>

				</div>

				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--/services-->

	<!--//services-->
	<!--/about-->
	<div class="about" id="about_one">
		<div class="container">
			<div class="about-main_w3_agileits">
				<div class="col-md-6 about-left">
					<img src="images/chef.jpg" alt="">
				</div>
				<div class="col-md-6 about-right_agileits">
					<h3>Chef Tasting Meal</h3>
					<p>If you feel adventurous, let our Chef prepare our ‘Chef Tasting Meal’ (shared for the whole table): highlights of our menu that best reflect the soul of Cuca and are inspired by the freshest market products. Rp. 580,000++ / person (inclusive of a selection of tapas, a dessert and our very unique digestives “Cuca Brews”).</p>
					<a class="active" href="/panel" data-target="">Reserve a table</a>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--//about-->
	<!--/tab_section-->
	<div class="tabs_section" id="menu">
		<div class="container">
			<h5>Special Menu</h5>
			<div id="horizontalTab">
				<ul class="resp-tabs-list">
					<li> Foods</li>
					<li> Cocktails</li>
					<li> Mocktails</li>
				</ul>
				<div class="resp-tabs-container">

					<div class="tab1">
						<div class="recipe-grid">
							@foreach($food as $m)
							<div class="col-md-6 menu-grids">
								<div class="menu-text_wthree">

									<div class="menu-text-left">
										<div class="rep-img">
											<img src="{{url('/images/menu-images/'.$m->image_name)}}" alt=" " class="img-responsive">
										</div>
										<div class="rep-text">
											<h4>{{$m->name}}</h4>
											<h6>{{$m->desc}}</h6>
										</div>

										<div class="clearfix"> </div>
									</div>
									<div class="menu-text-right">
										<h4>{{$m->price/1000}}K</h4>
									</div>
									<div class="clearfix"> </div>
								</div>
							</div>
							@endforeach

							<div class="clearfix"> </div>
						</div>

						<div class="clearfix"></div>
					</div>

					<div class="tab2">
						<div class="recipe-grid">
							@foreach($cocktail as $m)
							<div class="col-md-6 menu-grids">
								<div class="menu-text_wthree">

									<div class="menu-text-left">
										<div class="rep-img">
											<img src="{{url('/images/menu-images/'.$m->image_name)}}" alt=" " class="img-responsive">
										</div>
										<div class="rep-text">
											<h4>{{$m->name}}</h4>
											<h6>{{$m->desc}}</h6>
										</div>

										<div class="clearfix"> </div>
									</div>
									<div class="menu-text-right">
										<h4>{{$m->price/1000}}K</h4>
									</div>
									<div class="clearfix"> </div>
								</div>
							</div>
							@endforeach
							<div class="clearfix"> </div>
						</div>

						<div class="clearfix"></div>

					</div>
					<div class="tab3">
						<div class="recipe-grid">
								@foreach($mocktail as $m)
								<div class="col-md-6 menu-grids">
									<div class="menu-text_wthree">

										<div class="menu-text-left">
											<div class="rep-img">
												<img src="{{url('/images/menu-images/'.$m->image_name)}}" alt=" " class="img-responsive">
											</div>
											<div class="rep-text">
												<h4>{{$m->name}}</h4>
												<h6>{{$m->desc}}</h6>
											</div>

											<div class="clearfix"> </div>
										</div>
										<div class="menu-text-right">
											<h4>{{$m->price/1000}}K</h4>
										</div>
										<div class="clearfix"> </div>
									</div>
								</div>
								@endforeach
							<div class="clearfix"> </div>
						</div>

						<div class="clearfix"></div>
					</div>



					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- /tabs -->
	<!--//tab_section-->
	<!--/services-->
	<div class="choose">
		<div class="container">
			<div class="choose-main">
				<div class="col-md-12 choose-right">
					<div class="col-md-12 choose-right-top text-center">
						<h4>#BestinAsia</h4><br>
	<center>					<img src="{{url("/images/MichelinLogo-1.png")}}" class="img-responsive"></center>
						<p>Our endeavor to maintain the unwavering quality of our food makes our restaurant stand out from the crowd.
							Cuca Restaurant has arisen to be one of the top restaurants in Asia with a Michelin star. We are proud to serve you as one of the top 10 restaurants in Asia, on the island of Bali.</p>
					</div>

					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--//services-->
	<!--/gallery-->
	<div class="gallery" id="gallery">
		<div class="container">
			<div class="gallery-main">
				<div class="gallery-top">
					@foreach($food as $m)
					<div class="gallery-top-img portfolio-grids">
						<a href="{{url('/images/menu-images/'.$m->image_name)}}" class="b-link-stripe b-animate-go lightninBox" data-lb-group="1">
									<img src="{{url('/images/menu-images/'.$m->image_name)}}" alt="" />
									<div class="p-mask">
										<h4><span>{{$m->name}}</span></h4>
									</div>
								</a>

					</div>
					@endforeach
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<br>
	<!--//gallery-->


	@push('scripts')
	<script>
	$(function() {

$(".input input").focus(function() {

   $(this).parent(".input").each(function() {
	  $("label", this).css({
		 "line-height": "18px",
		 "font-size": "18px",
		 "font-weight": "100",
		 "top": "0px"
	  })
	  $(".spin", this).css({
		 "width": "100%"
	  })
   });
}).blur(function() {
   $(".spin").css({
	  "width": "0px"
   })
   if ($(this).val() == "") {
	  $(this).parent(".input").each(function() {
		 $("label", this).css({
			"line-height": "60px",
			"font-size": "24px",
			"font-weight": "300",
			"top": "10px"
		 })
	  });

   }
});

$(".button").click(function(e) {
   var pX = e.pageX,
	  pY = e.pageY,
	  oX = parseInt($(this).offset().left),
	  oY = parseInt($(this).offset().top);

   $(this).append('<span class="click-efect x-' + oX + ' y-' + oY + '" style="margin-left:' + (pX - oX) + 'px;margin-top:' + (pY - oY) + 'px;"></span>')
   $('.x-' + oX + '.y-' + oY + '').animate({
	  "width": "500px",
	  "height": "500px",
	  "top": "-250px",
	  "left": "-250px",

   }, 600);
   $("button", this).addClass('active');
})

$(".alt-2").click(function() {
   if (!$(this).hasClass('material-button')) {
	  $(".shape").css({
		 "width": "100%",
		 "height": "100%",
		 "transform": "rotate(0deg)"
	  })

	  setTimeout(function() {
		 $(".overbox").css({
			"overflow": "initial"
		 })
	  }, 600)

	  $(this).animate({
		 "width": "75px",
		 "height": "75px"
	  }, 500, function() {
		 $(".box").removeClass("back");

		 $(this).removeClass('active')
	  });

	  $(".overbox .title").fadeOut(300);
	  $(".overbox .input").fadeOut(300);
	  $(".overbox .button").fadeOut(300);

	  $(".alt-2").addClass('material-buton');
   }

})

$(".material-button").click(function() {

   if ($(this).hasClass('material-button')) {
	  setTimeout(function() {
		 $(".overbox").css({
			"overflow": "hidden"
		 })
		 $(".box").addClass("back");
	  }, 200)
	  $(this).addClass('active').animate({
		 "width": "700px",
		 "height": "700px"
	  });

	  setTimeout(function() {
		 $(".shape").css({
			"width": "60%",
			"height": "50%",
			"transform": "rotate(45deg)"
		 })

		 $(".overbox .title").fadeIn(300);
		 $(".overbox .input").fadeIn(300);
		 $(".overbox .button").fadeIn(300);
	  }, 700)

	  $(this).removeClass('material-button');

   }

   if ($(".alt-2").hasClass('material-buton')) {
	  $(".alt-2").removeClass('material-buton');
	  $(".alt-2").addClass('material-button');
   }

});

});</script>
	@endpush
	<!--//customer-->
	@endsection
