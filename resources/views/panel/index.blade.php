@extends('panel.layout.app')
@section("page_name") Dashboard @endsection
@section('content')
    <div class="container-fluid mt--7">

      <div class="row mt-5">
        <div class="col-xl-8 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">{{Auth::user()->role == 2 ? "Upcoming Reservation Today" : "Recent Reservation"}}</h3>
                </div>
                <div class="col text-right">
                  <a href="{{route('reservation.index')}}" class="btn btn-sm btn-primary">See all</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                  <th scope="col">Reservator Name</th>
                    <th scope="col">Reservation Code</th>
                    <th scope="col">Spaces</th>
                    <th scope="col">Reservation Date</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data['reservation'] as $r)
                  <tr>
                    <td>{{$r->user->name}}</td>
                    <th scope="row">
                    {{  $r->reservation_code}}
                    </th>
                    <td>
                      {{$r->space->name}}
                    </td>
                    <td>
                      {{Carbon\Carbon::parse($r->reservation_datetime)->format('d F Y H:i:s')}}
                    </td>
                    <td>
                    @if($r->payment_status == -2 )
                    <span class="badge badge-danger small">Reservation Cancelled</span>
                    @elseif($r->payment_status == -1)
                    <span class="badge badge-danger small">Waiting for Payment</span>
                    @elseif($r->payment_status == 0)
                    <span class="badge badge-primary small">Payment Complete</span>
                    @elseif($r->payment_status == 1)
                      <span class="badge badge-warning small">You didn't show up</span>
                    @elseif($r->payment_status == 2)
                      <span class="badge badge-success small">Reservation Completed</span>
                    @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @if(Auth::user()->role != 2)
        <div class="col-xl-4">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">My Points Logs</h3>
                </div>
                <div class="col text-right">
                  <a href="{{route('point.log')}}" class="btn btn-sm btn-primary">See all</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Point</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data['pointLog'] as $p)
                  <tr>
                    <th scope="row">
                      {{Carbon\Carbon::parse($p->created_at)->format('d-m-Y')}}
                    </th>
                    <td>
                      {{$p->points}}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @endif
      </div>
@endsection
