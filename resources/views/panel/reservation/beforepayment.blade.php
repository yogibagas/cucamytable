
<!-- Please use action : reservation.notifyNoPayment for no payment gateway -->
<!-- Use  https://staging.doku.com/Suite/Receive for payment gateway-->
<!-- Use   https://pay.doku.com/Suite/Receive for payment gateway-->
<form action="https://staging.doku.com/Suite/Receive" method="POST" id="formPayment" name="formPayment">
  @CSRF
<input type="HIDDEN" name="ADDITIONALDATA" class="form-control" value="{{$data->ADDITIONALDATA}}"><BR>
<input type="HIDDEN" name="GRANDTOTAL" id="grandTotal" class="form-control" value="{{$data->GRANDTOTAL}}"><BR>
<input type="HIDDEN" name="NAME" class="form-control" value="{{$data->NAME}} "><BR>
<input type="HIDDEN" name="SESSIONID" class="form-control" value="{{$data->SESSIONID}}"><BR>
<input type="HIDDEN" name="EMAIL" class="form-control" value="{{$data->EMAIL}}"><BR>
<input type="HIDDEN" name="REQUESTDATETIME" class="form-control" value="{{$data->REQUESTDATETIME}}"><BR>
<input type="HIDDEN" name="CHAINMERCHANT" class="form-control" value="{{$data->CHAINMERCHANT}}"><BR>
<input type="HIDDEN" name="BASKET" id="basket" class="form-control" value="{{$data->BASKET}}"><BR>
<input type="HIDDEN" name="CURRENCY" class="form-control" value="{{$data->CURRENCY}}"><BR>
<input type="HIDDEN" name="PURCHASECURRENCY" class="form-control" value="{{$data->PURCHASECURRENCY}}"><BR>
<input type="HIDDEN" name="AMOUNT" class="form-control" id="amount" value="{{$data->AMOUNT}}"><BR>
<input type="HIDDEN" name="PURCHASEAMOUNT" id="purchaseamount" class="form-control" value="{{$data->PURCHASEAMOUNT}}"><BR>
<input type="HIDDEN" name="PAYMENTCHANNEL" id="" class="form-control" value="{{$data->PAYMENTCHANNEL}}"><BR>
<input type="HIDDEN" name="MALLID" class="form-control" value="{{$data->MALLID}}"><BR>
<input type="HIDDEN" name="TRANSIDMERCHANT" class="form-control" value="{{$data->TRANSIDMERCHANT}}"><BR>
<input type="HIDDEN" name="WORDS" id="words" class="form-control" value=" {{$data->WORDS}} "><BR>
</form>
<script>
window.onload = function(){
  document.forms['formPayment'].submit();
}
</script>
