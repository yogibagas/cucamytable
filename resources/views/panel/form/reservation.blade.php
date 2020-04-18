
@extends('panel.layout.app')
@section('page_name') Restaurant Menu @endsection
@section('page_link') {{route('menu')}} @endsection
@section('content')
<div class="container-fluid mt--7">
  @if($errors->has('reservation_code'))
                <div class="alert alert-warning">
                   <ul class="m-0" style="list-style:bullet;">
                       @foreach ($errors->all() as $error)
                           <li>{!! $error !!}</li>
                       @endforeach
                   </ul>
               </div>
        @endif

      <div class="row">
        <div class="col">
            <div class="card shadow">
            <div class="card-header border-0">
              <center><h3 class="mb-0">Reservation Form</h3></center>
            </div>
            <section class="wizard-section">
		<div class="row no-gutters">
			<div class="col-lg-12 col-md-12">
				<div class="form-wizard">
					<form action="{{route('reservation.store')}}" method="post" role="form">
					@csrf
						<div class="form-wizard-header">
							<ul class="list-unstyled form-wizard-steps clearfix">
								<li class="active"><span>1</span></li>
								<li><span>2</span></li>
								<li><span>3</span></li>
								<li><span>4</span></li>
								<li><span>5</span></li>
							</ul>
						</div>
						<fieldset class="wizard-fieldset show">
						<center>

  					<h1 class="header-h">Mark your time! When do you want us to serve your table</h1>
                        </center>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for=""">Mark your date</label>
        							<input class="form-control dtpick" placeholder="Select date" type="text" value="" id="date" name="reservation_date">
									<div class="wizard-form-error"></div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for=""">Select your time</label>
									<input type="text" class=" form-control wizard-required fname" id="datetimepicker7" name="reservation_time">
									<div class="wizard-form-error"></div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="">Total Pax</label>
									<select class=" form-control wizard-required fname" id="pax" style="height:50px !important" name="total_pax">
									@for($min ; $min<=$max; $min++)
									<option value="{{$min}}">{{$min}}</option>
									@endfor
									</select>
									<div class="wizard-form-error"></div>
								</div>
							</div>
							</div>
							<div class="form-group clearfix">
								<a href="javascript:;" class="form-wizard-next-btn float-right" id="next1">Next</a>
							</div>
						</fieldset>
						<fieldset class="wizard-fieldset">
  					<center>	<h1 class="header-h">Choose where do you want us to serve your table</h1></center>
							<div class="fieldset2">
								<div class="d-flex flex-wrap mx-n3" id="content-field2">
								</div>
							</div>
							<div class="form-group clearfix">
								<a href="javascript:;" class="form-wizard-previous-btn float-left" id="back1">Previous</a>
								<a href="javascript:;" class="form-wizard-next-btn float-right" id="next2">Next</a>
							</div>
						</fieldset>
						<fieldset class="wizard-fieldset">
							<section id="menu-list" class="section-padding">
  				<div class="container">
						<div class="row">
							<div class="col-md-12 text-center  marb-35">
								<h1 class="header-h">Choose the menu you want us to serve</h1>
									</div>
									<div class="col-md-12 text-center" id="menu-filters">
										<ul>
											<li><a class="filter active" data-filter=".menu-restaurant">Show All</a></li>
										@foreach($menu_cat as $menu_ct)
											<li><a class="filter " data-filter=".{{$menu_ct->id}}">{{$menu_ct->name}}</a></li>
										@endforeach
										</ul>
									</div>
									<div id="menu-wrapper">
									@foreach($menu as $modelMenu)
										<div class="{{$modelMenu->category->id}} menu-restaurant">
											<span class="clearfix" style="border-bottom:1px dotted;">
												<a href="#" class="menu-title" href="#" data-meal-img=".jpg">{{$modelMenu->name}}</a>

									<label for="{{$modelMenu->id}}">
									<small>({{$modelMenu->category->name}})</small>
												<span class="menu-price">{{substr($modelMenu->price,0,-3)}}K</span>
											</span>
											<span class="menu-subtitle">{{$modelMenu->desc}}</span>
											<span class="menu-subtitle" style="float:right;">
											<input type="checkbox" name="id_menu[]" class="id-menu" value="{{$modelMenu->id}}" id="{{$modelMenu->id}}"></span>
										</label>
										</div>
										@endforeach
									</div>
							</div>
							<div class="form-group clearfix">
								<a href="javascript:;" class="form-wizard-previous-btn float-left" id="back2">Previous</a>
								<a href="javascript:;" class="form-wizard-next-btn float-right" id="qtyOrder">Decide Quantity</a>
							</div>
		 				</div>
						</fieldset>
						<fieldset class="wizard-fieldset">
  					<center>	<h1 class="header-h">Choose how many food we serve for each menu you choose</h1></center>
							<div id="reviewMenu"></div>

							<div class="form-group clearfix">
								<a href="javascript:;" class="form-wizard-previous-btn float-left" id="back3">Previous</a>
								<a href="javascript:;" class="form-wizard-next-btn float-right" id="reviewOrder">Review Your Reservation</a>
							</div>
						</fieldset>
						<fieldset class="wizard-fieldset">
						<center>
              <h1 class="header-h text-green">Review Your Order</h1>
            </center>
						<div class="container">
						<div class="row pt-3"  >
							<div class="col-md-2"></div>
							<div class="col-md-8 p-0" >
								<div class="row" style="border:1px solid #a5783f;">
									<div class="col-md-12 header p-0 bg-plain-white">
										<img src="{{url('images/reservation/header.png')}}" class="img-fluid">
									</div>
									<div class="col-md-12 body-form p-0">
										<div class="table table-responsive">
											<table class="table table-bordered bg-plain-white">
												<thead>
                          <tr>
													<th colspan="2">
														<center><h2>Please Review your reservation below</h2></center>
                          </th>
                        </tr>
  													<tr>
  														<th colspan="4" class="text-center">
  															<strong><h4>Reservation Detail</h4></strong>
  														</th>
  													</tr>
												</thead>
                      </table>
                      <table class="table table-striped bg-plain-white">
												<tbody>
													<tr>
														<td>Date : </td>
                            <td class="text-bold" id="date_value">
                            </td>
														<td>Time : </td>
                            <td class="text-bold" id="time_value">
                            </td>
													</tr>
                          <tr>
                            <td>Pax :</td>
                            <td class="text-bold" id="pax_value">
                            </td>
                            <td>Space :</td>
                            <td class="text-bold" id="space_value">
                            </td>
                          </tr>
												</tbody>
											</table>
                      <table class="table table-bordered bg-plain-white">
                        <thead>
                          <tr>
                          <th colspan="6" class="text-center">
															<strong><h4>Picked Menu</h4></strong>
                          </th>
                        </tr>
                        <tr>
                          <th colspan="3" class="text-center text-bold"><h5>Menu Name</h5></th>
                            <th colspan="1" class="text-center text-bold"><h5>Quantity</h5></th>
                              <th colspan="1" class="text-center text-bold"><h5>Price /Qty </h5></th>
                                <th colspan="1" class="text-center text-bold"><h5>Total </h5></th>
                        </tr>
                        </thead>
                        <tbody id="menu-body">
                        </tbody>
                        <tfoot>
                          <td colspan="5" class="text-bold">Total Price <small>(not include 18.8% for service and tax )</small> </td>
                          <td class="text-right text-bold" id="total_value"></td>
                        </tfoot>
                      </table>
                      <table class="table table-bordered bg-plain-white">
                        <thead>
                          <tr>
                          <th colspan="6" class="text-center">
															<strong><h4>Special Notes</h4></strong>
                          </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                          <td>  <textarea class="form-control" placeholder="if you have a notes how we serve your table please put it here." name="special_notes"></textarea>
                          </td>
                        </tr>
                        </tbody>
                      </table>
										</div>
									</div>
								</div>

    							<div class="form-group clearfix">
    								<a href="javascript:;" class="form-wizard-previous-btn float-left" id="back3">Previous</a>
    								<input type="submit" class="form-wizard-submit float-right">
    							</div>
							</div>
							<div class="col-md-2"></div>
						</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</section>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')

<script>
(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };
}(jQuery));
$(document).ready(function(){

// Menu filter
$("#menu-filters li a").click(function() {
  $("#menu-filters li a").removeClass('active');
  $(this).addClass('active');

  var selectedFilter = $(this).data("filter");
  //  $("#menu-wrapper").fadeTo(100, 0);

  $(".menu-restaurant").fadeOut();

  setTimeout(function() {
	$(selectedFilter).slideDown();
	//$("#menu-wrapper").fadeTo(300, 1);
  }, 300);
});

})




var currentYear = new Date();
$('.dtpick').datepicker({
	startDate: '+1d'
    // yearStart : currentYear.getFullYear(), // Start value for current Year selector
    // onChangeDateTime:checkPastTime,
    // onShow:checkPastTime
});
jQuery(document).ready(function() {
	$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$("#datetimepicker7").timepicker({
	minTime : '08:00',
	maxTime: '10:00 PM',
	interval : '60',
	defaultTime : '08:00 AM',
	timeFormat:'H:mm'
});


	// click on next button
	jQuery('.form-wizard-next-btn').click(function() {
		var step = $(this).attr('id');
		if(step == "next1"){
			//validation
			if(!$("#date").val()){
				alert('Choose your date');
				$("#date").focus();
				return false;
				}else if(!$("#pax").val() && $("#pax").val()<2){
				alert("Minimum pax is 2");
				$("#pax").focus();
				return false;
			}

		var data = {
			"_token":$('meta[name="csrf-token"]').attr('content'),
			"date":$("#date").val() ,
			"time":$("#datetimepicker7").val(),
			"pax": $("#pax").val()
		};
		var spaces = "";
			$.ajax({
               type:'POST',
               url:'{{route("reservation.step1")}}',
               data:data,
               success:function(result) {
				   //console.log(result);
				   $("#content-field2").html("");
				  $.each(result,function(data,item){
					//   console.log(item);
					  $("#content-field2")
					  .append(
						  `<div class="m-3 width-30" style="text-align:center;border:2px solid #000;padding:10px 30px;">
						  <label for="`+item.id+`">
						  	<div class="card">
								<div class="card-header"><h5>`+item.name+`</h5></div>
								<div class="card-body">
								<img src="{{url('images/spaces/`+item.image+`')}}" class="img-responsive height-320px" style="width:100%;"><br>
									<br>
								<span class="desc mt-2">`+item.desc+`</span><br>
								</div>
								<div class="card-footer">
									<input type="radio" id="`+item.id+`" name="id_spaces" value="`+item.id+`">
								</div>
							</label>
							</div>`
									);
								});
              			 }
            });
         }
		 else if(step == "next2"){
			 if($("input[name='id_spaces']:checked").length <= 0){
				 alert('Please choose one of our available space');
			 return false;
			 }
			//  if($("#id_spaces").length() );
		 }
				 else if(step == "qtyOrder"){
					 if($(".id-menu:checked").length <= 0){
						 alert('Please tick atleast one of our delicious menu');
						 return false;
					 }

					var selectedMenu = $(".id-menu:checked").map((index, item) => $(item).val() );
					var selected = [];
					$.each(selectedMenu,function(data,item){
						selected.push(item);
					});

					var data = {
						"_token":$('meta[name="csrf-token"]').attr('content'),
						"id_menu": selected ,

					};
					$.ajax({
						type:"POST",
						url:'{{route("reservation.menucheck")}}',
						data:data,
						success(result){
							// console.log(result);
							$("#reviewMenu").html("");
							$.each(result,function(data,item){
								$("#reviewMenu").append(`
								<div class="row border" style="margin-top:10px;">
									<div class="col-md-1 border-right p-0">
										<img src="{{url('images/menu-images/`+item.image_name+`')}}" width="100%" height="100%">
									</div>
									<div class="col-md-5 border-right"><b style="text-transform:capitalize">Menu Name : `+item.name+`<small>(`+item.category.name+`)</small></b><br>
									<small>Menu Description : `+item.desc+`</small>
									</div>
									<div class="col-md-4 border-right">Menu Price : <br><small>(The price below is exclude tax and service)</small><br>Rp. `+addCommas(item.price)+`/pcs</div>
									<div class="col-md-2 border-right">
										<div class="form-group">
										<label>Qty :</label>
										<input type="number" class="qty form-control" name="qty[]" min="1" value="1" id="qty`+item.id+`">
										</div>
									</div>
								</div> `);
							});
						}
					});
				 }
         else if(step == "reviewOrder"){

           const qtys = $('#reviewMenu').find('.qty');

           for(var i = 0; i < qtys.length; i++) {
             const currentQty = $(qtys[0])
             if(currentQty.val() <= 0) {
               currentQty.focus();

               alert('quantity must be 1 or more');
               return
             }
           }

           //get reservation details
           var date = $("#date").val();
           var time = $("#datetimepicker7").val();
           var pax = $("#pax").val();
           var space = $("input[name='id_spaces']:checked").val();
           //selected menu
           var selectedMenu = $(".id-menu:checked").map((index, item) => $(item).val() );
 					var selected = [];
          var qty = [];
 					$.each(selectedMenu,function(data,item){
 						selected.push(item);
            // qtyName = $("#qty"+item)l
            qty.push($("#qty"+item).val());
 					});

          var data = {
						"_token":$('meta[name="csrf-token"]').attr('content'),
            'date' : date,
            'time' : time,
            'pax' : pax,
            'id_space' : space,
            'id_menu' : selected,
            'qty_menu': qty,
          }

          $.ajax({
            type:"POST",
            url:'{{route("reservation.revieworder")}}',
            data:data,
            success(result){
              $("#date_value").html(result.date);
              $("#pax_value").html(result.pax);
              $("#time_value").html(result.time);
              $("#space_value").html(result.space);
              var total_price = 0;
              var append = '';
              var total_each =0;
     					$.each(result.menu,function(data,item){
                total_each = item.price*item.qty
                total_price += total_each
                append += `<tr>
                <td colspan="3" style="text-transform:capitalize;">`+data+`<small>(`+item.category+`)</td>
                <td class="text-center">`+item.qty+`</small></td>
                <td class="text-right">Rp. `+addCommas(item.price)+`</td>
                <td class="text-right">Rp. `+addCommas(total_each)+`</td>
                </tr>`;
              });
              $("#menu-body").html(append);
              $("#total_value").html('Rp. '+addCommas(total_price));
               // console.log(result);
              // console.log(total_price);
            }
          });

           // console.log(qty);
         }

    $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
		var parentFieldset = jQuery(this).parents('.wizard-fieldset');
		var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
		var next = jQuery(this);
		var nextWizardStep = true;
		parentFieldset.find('.wizard-required').each(function(){
			var thisValue = jQuery(this).val();

			if( thisValue == "" && $("#pax").val() <= 1) {
				jQuery(this).siblings(".wizard-form-error").slideDown();
				nextWizardStep = false;
			}
			else {
			//validate pax must be more than one]
				jQuery(this).siblings(".wizard-form-error").slideUp();
			}
		});

			if($("#pax").val() <= 1 ){
				nextWizardStep = false;
				alert('Minimum Pax is 2');
			}
		if( nextWizardStep) {
			next.parents('.wizard-fieldset').removeClass("show","400");
			currentActiveStep.removeClass('active').addClass('activated').next().addClass('active',"400");
			next.parents('.wizard-fieldset').next('.wizard-fieldset').addClass("show","400");
			jQuery(document).find('.wizard-fieldset').each(function(){
				if(jQuery(this).hasClass('show')){
					var formAtrr = jQuery(this).attr('data-tab-content');
					jQuery(document).find('.form-wizard-steps .form-wizard-step-item').each(function(){
						if(jQuery(this).attr('data-attr') == formAtrr){
							jQuery(this).addClass('active');
							var innerWidth = jQuery(this).innerWidth();
							var position = jQuery(this).position();
							jQuery(document).find('.form-wizard-step-move').css({"left": position.left, "width": innerWidth});
						}else{
							jQuery(this).removeClass('active');
						}
					});
				}
			});
		}
	});
	//click on previous button
	jQuery('.form-wizard-previous-btn').click(function() {
		var counter = parseInt(jQuery(".wizard-counter").text());;
		var prev =jQuery(this);
		var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
		prev.parents('.wizard-fieldset').removeClass("show","400");
		prev.parents('.wizard-fieldset').prev('.wizard-fieldset').addClass("show","400");
		currentActiveStep.removeClass('active').prev().removeClass('activated').addClass('active',"400");
		jQuery(document).find('.wizard-fieldset').each(function(){
			if(jQuery(this).hasClass('show')){
				var formAtrr = jQuery(this).attr('data-tab-content');
				jQuery(document).find('.form-wizard-steps .form-wizard-step-item').each(function(){
					if(jQuery(this).attr('data-attr') == formAtrr){
						jQuery(this).addClass('active');
						var innerWidth = jQuery(this).innerWidth();
						var position = jQuery(this).position();
						jQuery(document).find('.form-wizard-step-move').css({"left": position.left, "width": innerWidth});
					}else{
						jQuery(this).removeClass('active');
					}
				});
			}
		});
	});
	//click on form submit button
	jQuery(document).on("click",".form-wizard .form-wizard-submit" , function(){
		var parentFieldset = jQuery(this).parents('.wizard-fieldset');
		var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
		parentFieldset.find('.wizard-required').each(function() {
			var thisValue = jQuery(this).val();
			if( thisValue == "" ) {
				jQuery(this).siblings(".wizard-form-error").slideDown();
			}
			else {
				jQuery(this).siblings(".wizard-form-error").slideUp();
			}
		});
	});
	// focus on input field check empty or not
	jQuery(".form-control").on('focus', function(){
		var tmpThis = jQuery(this).val();
		if(tmpThis == '' ) {
			jQuery(this).parent().addClass("focus-input");
		}
		else if(tmpThis !='' ){
			jQuery(this).parent().addClass("focus-input");
		}
	}).on('blur', function(){
		var tmpThis = jQuery(this).val();
		if(tmpThis == '' ) {
			jQuery(this).parent().removeClass("focus-input");
			jQuery(this).siblings('.wizard-form-error').slideDown("3000");
		}
		else if(tmpThis !='' ){
			jQuery(this).parent().addClass("focus-input");
			jQuery(this).siblings('.wizard-form-error').slideUp("3000");
		}
	});
});


function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

</script>

<script>
                            $(document).ready(function(){
                                $(".lname").on('keypress',function(e){
                                    $(".usernem").val($(this).val());
                                });
                            });
							</script>
@endpush
