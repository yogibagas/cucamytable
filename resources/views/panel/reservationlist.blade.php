@extends('panel.layout.app')
@section("page_name") Dashboard @endsection
@section('content')
<style>
.bg-success{
  background:#5FC878;
}
.bg-failed{
  background:red;
}
.bg-warning{
  background:orange;
}
.bg-blue{
  background:blue;
}
.bg {
  width: 100%;
  overflow: hidden;
  margin: 0 auto;
  box-sizing: border-box;
  padding: 40px;
  margin-top: 40px;
}
.cards {
  background-color: #fff;
  width: 100%;
  float: left;
  margin-top: 40px;
  border-radius: 5px;
  box-sizing: border-box;
  padding: 80px 30px 25px 30px;
  text-align: center;
  position: relative;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}
.card__success {
  position: absolute;
  top: -50px;
  left: 145px;
  width: 100px;
  height: 100px;
  border-radius: 100%;
  background-color: #60c878;
  border: 5px solid #fff;
}
.card__failed {
  position: absolute;
  top: -50px;
  left: 145px;
  width: 100px;
  height: 100px;
  border-radius: 100%;
  background-color: #red;
  border: 5px solid #fff;
}

.card__failed i {
  color: #fff;
  line-height: 90px;
  font-size: 45px;
}
.card__success i {
  color: #fff;
  line-height: 90px;
  font-size: 45px;
}
.card__msg {
  text-transform: uppercase;
  color: #55585b;
  font-size: 18px;
  font-weight: 500;
  margin-bottom: 5px;
}
.card__submsg {
  color: #959a9e;
  font-size: 16px;
  font-weight: 400;
  margin-top: 0px;
}
.card__body {
  background-color: #f8f6f6;
  border-radius: 4px;
  width: 100%;
  margin-top: 30px;
  float: left;
  box-sizing: border-box;
  padding: 30px;
}
.card__avatar {
  width: 50px;
  height: 50px;
  border-radius: 100%;
  display: inline-block;
  margin-right: 10px;
  position: relative;
  top: 7px;
}
.card__recipient-info {
  display: inline-block;
}
.card__recipient {
  color: #232528;
  text-align: left;
  margin-bottom: 5px;
  font-weight: 600;
}
.card__email {
  color: #838890;
  text-align: left;
  margin-top: 0px;
}
.card__price {
  color: #232528;
  font-size: 30px;
  margin-top: 25px;
  margin-bottom: 30px;
}
.card__price span {
  font-size: 60%;
}
.card__method {
  color: #d3cece;
  text-transform: uppercase;
  text-align: left;
  font-size: 11px;
  margin-bottom: 5px;
}
.card__payment {
  background-color: #fff;
  border-radius: 4px;
  width: 100%;
  height: 100px;
  box-sizing: border-box;
  display: flex;
  align-items: center;
  justify-content: center;
}
.card__credit-card {
  width: 50px;
  display: inline-block;
  margin-right: 15px;
}
.card__card-details {
  display: inline-block;
  text-align: left;
}
.card__card-type {
  text-transform: uppercase;
  color: #232528;
  font-weight: 600;
  font-size: 12px;
  margin-bottom: 3px;
}
.card__card-number {
  color: #838890;
  font-size: 12px;
  margin-top: 0px;
}
.card__tags {
  clear: both;
  padding-top: 15px;
}
.card__tag {
  text-transform: uppercase;
  background-color: #f8f6f6;
  box-sizing: border-box;
  padding: 3px 5px;
  border-radius: 3px;
  font-size: 10px;
  color: #d3cece;
}

</style>
    <!-- Table -->
    <div class="container-fluid mt--7">

    <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
                <div class="row">
                    <div class="col-6">
                    <h3 class="mb-3">My Reservation </h3>
                    <a href="{{route('reservation.create')}}" class="btn btn-primary">Create New </a>
                    </div>
                    <div class="col-6">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success mt-3">
                            {{ $message }}
                        </div>
                        @elseif($message = Session::get('failed'))
                        <div class="alert alert-danger mt-3">
                            {{ $message }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
            <div class="row">
              @foreach($data as $d)
                  <div class="col-md-4">
                    <div class="bg
                    @if($d->payment_status == -2 )
                      bg-failed
                      @elseif($d->payment_status == -1)
                      bg-warning
                      @elseif($d->payment_status == 0)
                      bg-success
                      @elseif($d->payment_status == 1)
                      bg-warning
                      @elseif($d->payment_status == 2)
                      bg-success
                      @endif">

                          <div class="cards">
                            <span class="card__success">
                              @if($d->payment_status == -2 )
                              <i class="fa fa-times"></i>
                              @elseif($d->payment_status == -1)
                              <i class="ni ni-button-pause"></i>
                              @elseif($d->payment_status == 0)
                              <i class="fa fa-check"></i>
                              @elseif($d->payment_status == 1)
                              <i class="ni ni-user-run"></i>
                              @elseif($d->payment_status == 2)
                              <i class="fa fa-check"></i>
                              @endif
                            </span>

                            <h1 class="card__msg">
                                @if($d->payment_status == -2 )
                                Reservation Cancelled
                                @elseif($d->payment_status == -1)
                                Waiting for Payment
                                @elseif($d->payment_status == 0)
                                Reservation Confirmed
                                @elseif($d->payment_status == 1)
                                You didn't show up
                                @elseif($d->payment_status == 2)
                                Reservation Completed
                                @endif
                            </h1>
                            <h2 class="card__submsg"><b>Reservation Time</b> <br>{{\Carbon\Carbon::parse($d->reservation_datetime)->format('d F Y H:i:s')}}</h2>

                            <div class="card__body">

                              <p class="card__method">Reservation Code</p>
                              <div class="card__payment">
                                <div class="card__card-details">
                                  <p class="card__card-type">{{$d->reservation_code}}</p>
                                </div>
                              </div>

                            </div>

                          <div class="card__tags">
                            <a href="{{route('reservation.summary',$d->reservation_code)}}" class="btn {{$d->payment_status == -1 ? "btn-warning":"btn-primary"}}">
                              {{$d->payment_status == -1 ? "Pay Reservation": "Detail Reservation"}}
                            </a><br><br>
                              <span class="card__tag">Created At : {{\Carbon\Carbon::parse($d->created_at)->format('d F Y')}}</span>
                          </div>
                          </div>

                        </div>
                    </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
