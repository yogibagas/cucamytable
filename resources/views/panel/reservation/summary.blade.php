@extends('panel.layout.app')
@section('page_name') Your Reservation Summary @endsection
@section('page_link') {{route('reservation.list')}} @endsection
@section('content')
<!-- change action to reservation.notifyNopayment if remove payment gateway -->
<!-- change action to reservation.payment if use payment gateway -->
<form action="{{ Auth::user()->role == 2 ? route('reservation.complete') : route('reservation.payment')}}" method="POST">
	@csrf
	<div class="container">
						<div class="row pt-3">
							<div class="col">
							<div class="col-md-12 p-0">
								<div class="row bg-plain-white" style="border:1px solid #a5783f;" >
									<div class="col-md-12 header p-0 bg-plain-white">
										<img src="{{url('/images/reservation/header.png')}}" class="img-fluid">
									</div>
									<div class="col-md-12 p-0 m-0">
										@if ($reservation->payment_status == -2)
												<center><h4 class="m-0" style="background:red;color:#FFF;padding-top:15px;padding-bottom:15px;">{{ "This Reservation Has Been Canceled" }}</h4></center>
										@elseif($reservation->payment_status == -1)
										<center><h4 class="m-0" style="background:blue;color:#FFF;padding-top:15px;padding-bottom:15px;">{{ "Please Complete Your Payment Before" }}
											{{$expired_date}}</h4></center>
										@elseif($reservation->payment_status == 0)
												<center><h4 class="m-0" style="background:orange;color:#FFF;padding-top:15px;padding-bottom:15px;">We are Ready To Serve You!<br>
													Your Reservation Time is <b><u>{{ $reservation->reservation_datetime  }}</b></u></h4></center>
									 @elseif($reservation->payment_status == 1)
												<center><h4 class="m-0" style="background:brown;color:#FFF;padding-top:15px;padding-bottom:15px;"> You did not show up on your reservation time!<br>
													 Your reservation was made for <b><u>{{ \Carbon\Carbon::parse($reservation->reservation_datetime)->format('d F Y H:i')  }}</b></u></h4></center>
										@endif
									</div>
									<div class="col-12 text-center bg-plain-white pt-3 pb-3 border-bottom">
										<h4>
											Reservation made for <b>{{$reservation->user->name}}</b><br>
											@if($reservation->payment_status == 0)
											Please provide reservation code below when come to Cuca to Confirm your Reservation</br>
											@endif
											Reservation Code : <b>{{$reservation->reservation_code}} </b>
										</h4>
									</div>
										<div class="table table-responsive">
											<table class="table table-bordered bg-plain-white m-0">
												<thead>
                          <tr>
													<th colspan="2 p-3">

                          </th>
                        </tr>
												</thead>
                      </table>
                      <table class="table table-striped bg-plain-white m-0">
												<tbody>
													<tr>
														<td>Date : </td>
                            <td class="text-bold" id="date_value">
															<INPUT TYPE="text" readonly="" class="p-0 bg-none border-0 text-bold" value="{{ \Carbon\Carbon::parse($reservation->reservation_datetime)->format('d-m-Y')}}">
																</td>
														<td>Time : </td>
                            <td class="text-bold" id="time_value">
															<INPUT TYPE="text" readonly="" class="p-0 bg-none border-0 text-bold" value="{{ \Carbon\Carbon::parse($reservation->reservation_datetime)->format('H:i')}}">
														</td>
													</tr>
                          <tr>
                            <td>Pax :</td>
                            <td class="text-bold" id="pax_value">
															<INPUT TYPE="text" readonly="" class="p-0 bg-none border-0 text-bold" value="{{$reservation->total_pax}}">
															</td>
                            <td>Space :</td>
                            <td class="text-bold" id="space_value">
															<INPUT TYPE="text" readonly="" class="p-0 bg-none border-0 text-bold" value="{{$reservation->space->name}}">
														</td>
                          </tr>
                          <tr>
                            <td colspan="4"><b>Special Notes :</b><br>
															{{$reservation->special_notes}}

														</td>
													</tr>
												</tbody>
											</table>
                      <table class="table table-bordered bg-plain-white m-0">
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
                        <tbody id="menu-body"><tr>
													@foreach($reservation->detailReservation as $menu)
						                <td colspan="3" style="text-transform:capitalize;">{{$menu->name}}<small>({{$menu->category->name}})</small></td>
						                <td class="text-center">{{$menu->pivot->qty}}</td>
						                <td class="text-right">Rp. {{number_format($menu->price)}}</td>
						                <td class="text-right">Rp. {{number_format($menu->price*$menu->pivot->qty)}}</td>
						                </tr>
													@endforeach
													@if($reservation->payment_status >= 0)
													<tr>
														<td colspan="6" class="text-center text-bold">Payment Breakdown</td>
													</tr>
													<tr>
														<td colspan="5" class=" text-bold">Tax </td>
														<td class="text-right text-bold">Rp. {{number_format($calculation['tax'],0,".",",")}}</td>
													</tr>
													<tr>
														<td colspan="5" class=" text-bold">Service </td>
														<td class="text-right text-bold">Rp. {{number_format($calculation['service'],0,".",",")}}</td>
													</tr>
													<tr>
														<td colspan="5" class=" text-bold">Total </td>
														<td class="text-right text-bold text-bold">Rp. {{number_format($calculation['total'],0,".",",")}}</td>
													</tr>
													<tr>
														<td colspan="5" class=" text-bold">Point Used </td>
														<td class="text-right text-bold">Rp. {{number_format($reservation->discount,0,".",",")}}</td>
													</tr>
													<tr>
														<td colspan="5" class=" text-bold">Deposit</td>
														<td class="text-right text-bold">Rp. {{number_format((0.5*$calculation['total']),0,".",",")}}</td>
													</tr>
													@endif
													@if($reservation->payment_status == -1)
													<tr>
														<td class="text-center" colspan="6">
															<strong><h4>Payment Breakdown</h4></strong>
														</td>
													</tr>
													@endif
												</tbody>
												@if($reservation->payment_status == -1)
                        <tfoot style="background:rgba(0, 0, 0, 0.05);">
                          <tr>
														<td colspan="5" class="text-bold">Sub Total<small>(Food Items)</small> </td>
	                          <td class="text-right text-bold" id="total_value">IDR. {{number_format($calculation['subTotal'],0,".",",")}}</td>
	                        </tr>
                          <tr>
														<td colspan="5" class="text-bold ">Tax<small>(10.8%)</small </td>
	                          <td class="text-right text-bold" id="total_value">IDR. {{number_format($calculation['tax'],0,".",",")}}</td>
	                        </tr>
                          <tr>
														<td colspan="5" class="text-bold ">Services<small>(8%)</small </td>
	                          <td class="text-right text-bold" id="total_value">IDR. {{number_format($calculation['service'],0,".",",")}}</td>
	                        </tr>
                          <tr>
														<td colspan="5" class="text-bold ">Grand Total </td>
	                          <td class="text-right text-bold" id="total_value">IDR. {{number_format($calculation['total'],0,".",",")}}</td>
	                        </tr>
											</tfoot>
											@endif
                      </table>
											@if($reservation->payment_status == -1)
                      <table class="table table-bordered bg-plain-white">
                        <thead>
                          <tr>
                          <th colspan="8" class="text-center">
															<strong><h4>Detail Payment</h4></strong><br>
                          </th>
                        </tr>
                        </thead>
                        <tbody>
													<tr>
														<td class="text-bold" colspan="5">Down Payment<small>(50% from Grand Total)</small></td>
														<td class="text-right text-bold">IDR. <input class="bg-none border-0 text-right text-bold" id="dpPrice"></td>
													</tr>
													<tr>
														<td class="text-bold" colspan="5">Point Worth</small></td>
														<td class="text-right text-bold">IDR. <input class="bg-none border-0 text-right text-bold" value="0" name="discount" id="discount"></td>
													</tr>
													<tr>
														<td class="text-bold" colspan="5">Total Pay</small></td>
														<td class="text-right text-bold">IDR. <input class="bg-none border-0 text-right text-bold" value="0" name="total_pays" id="total_pays"></td>
													</tr>

													@if($points >0 )
													<tr>
														<td class="text-bold">
															<label>Use my {{$points}} Points in a payment (maximum 50% from Total Pay) </label><br>
															<label class="custom-toggle">
															  <input type="checkbox" name="usePoint" id="usePoint">
															  <span class="custom-toggle-slider rounded-circle"></span>
															</label>
														</td>
													</tr>
													@endif
                        </tbody>
                      </table>
											<div class="col-md-12">
												<ul style="list-style-type:circle;">
												<li>
													Belongs to Cuca <a href="#">Terms & Condition</a> , user that make reservation must pay 50% as guarantee not showing up on reservation time and the rest can pay in the restaurant.</div>
												</li>
											</ul>
										</div>
										@endif
									</div>
								</div>
								<input type="HIDDEN" name="ADDITIONALDATA" class="form-control" value=" {{Auth::user()->name}};{{$reservation->total_pax }};{{$reservation->reservation_datetime}};{{$reservation->space->name}}">
								<input type="HIDDEN" name="GRANDTOTAL" id="grandTotal" class="form-control" value="">
								<input type="HIDDEN" name="NAME" class="form-control" value="{{$reservation->user->name}} ">
								<input type="HIDDEN" name="SESSIONID" class="form-control" value="{{md5(uniqid(rand(), true))}}">
								<input type="HIDDEN" name="EMAIL" class="form-control" value="{{$reservation->user->email}}">
								<input type="HIDDEN" name="REQUESTDATETIME" class="form-control" value="{{date("YmdHis")}}">
								<input type="HIDDEN" name="CHAINMERCHANT" class="form-control" value="NA">
								<input type="HIDDEN" name="BASKET" id="basket" class="form-control" value="{{$basket}}">
								<input type="HIDDEN" name="CURRENCY" class="form-control" value="360">
								<input type="HIDDEN" name="PURCHASECURRENCY" class="form-control" value="360">
								<input type="HIDDEN" name="AMOUNT" class="form-control" id="amount" value="">
								<input type="HIDDEN" name="PURCHASEAMOUNT" id="purchaseamount" class="form-control" value="">
								<input type="HIDDEN" name="PAYMENTCHANNEL" id="" class="form-control" value="15">
								<input type="HIDDEN" name="MALLID" class="form-control" value="11229763">
								<input type="HIDDEN" name="TRANSIDMERCHANT" class="form-control" value="{{$reservation->reservation_code}}">
								<input type="HIDDEN" name="WORDS" id="words" class="form-control" value="{{sha1((50/100*$calculation['total']) . '.00' . '11229763' . 'OStHTQCoLUuY' . $reservation->reservation_code)}} ">

    							<div class="form-group clearfix">
										@if(Auth::user()->role == 2)

    								<a href="{{route('reservation.index')}}" class="btn btn-primary float-left" id="back3">Back to Reservation List</a>
										@if($reservation->payment_status >= 0 && $reservation->payment_status != 2)
    								<button type="submit" class="btn btn-flat btn-success float-right" style="cursor:pointer">Mark as Complete</button>
										@endif

										@endif
										@if(Auth::user()->role != 2)
    								<a href="{{route('reservation.list')}}" class="btn btn-warning float-left" id="back3">My Reservation</a>
										@if($reservation->payment_status == "-1")
    								<!-- <a href="#" type="submit" class="btn btn-flat btn-success float-right" style="cursor:pointer">Pay Now</a> -->
    								<button type="submit" class="btn btn-flat btn-success float-right" style="cursor:pointer">Pay Now</button>
										@endif
										@endif
    							</div>
							</div>
						</div>
						</div>
						</div>
@push('scripts')

<script>
$(document).ready(function(e){
	var downPaymentPrice = (50/100) * {{$calculation['total']}};
	var basket = "{{$basket}}";
	// console.log(downPaymentPrice);
	$("#dpPrice").val(addCommas(downPaymentPrice));
		$("#total_pays").val(addCommas(downPaymentPrice));
		$("#grandTotal").val(downPaymentPrice+".00");
		$("#amount").val(downPaymentPrice+".00");
		$("#purchaseamount").val(downPaymentPrice+".00");
		var printBasket = basket+";Down Payment,-"+downPaymentPrice+".00"+",1,"+"-"+downPaymentPrice+".00";
		$("#basket").val(printBasket);
	//check point used or not
		var clicking = 1;
	$("#usePoint").on('change',function(){
		var basket = "{{$basket}}";
		var dpPrice = (50/100) * {{$calculation['total']}};
		var points = {{$points}};
		var grandTotal = dpPrice;
		if(clicking == 1){
			grandTotal -= points;
			$("#discount").val(addCommas(points));
			printBasket += ";Points,-"+points+".00"+",1,"+"-"+points+".00";
		clicking++;
	}else{
		grandTotal = dpPrice;
		$("#discount").val(0);
		printBasket = basket+";Down Payment,-"+downPaymentPrice+".00"+",1,"+"-"+downPaymentPrice+".00";
		clicking--;
	}

	$("#total_pays").val(addCommas(grandTotal));
	$("#grandTotal").val(grandTotal+".00");
	$("#amount").val(grandTotal+".00");
	$("#purchaseamount").val(grandTotal+".00");
	$("#basket").val(printBasket);

	// $calculation['total'] . '.00' . '11229763' . 'YhaXnBGdXutG' . $reservation->reservation_code
	var data = {
		"_token":$('meta[name="csrf-token"]').attr('content'),
	 'amount' : grandTotal+".00",
	 'merchantID' : '11229763',
	 'shareKey' : 'OStHTQCoLUuY',
	 'reservationCode' : '{{$reservation->reservation_code}}',
}
	$.ajax({
		data : data,
		method : "POST",
		url:'{{route("reservation.getwords")}}',
		success(result){
			$("#words").val(result);
		}
	});


		// if($(this).val('on'))
		// 	// alert('checked');
		// 	else {
		// 		// alert('not checked');
		// 	}
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
@endpush
@endsection
