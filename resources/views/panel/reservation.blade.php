@extends('panel.layout.app')
@section("page_name") Dashboard @endsection
@section('content')
    <!-- Table -->
    <div class="container-fluid mt--7">

    <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
                <!-- alert
            <div class="alert alert-success" role="alert">
                <strong>Success!</strong> This is a success alert—check it out!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="alert alert-danger" role="alert">
                <strong>Danger!</strong> This is a failed alert—check it out!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </button>
            </div> -->
            <!-- //Alert -->
                <div class="row">
                    <div class="col-6">
                    <h3 class="mb-3">Reservation Data </h3>
                    </div>
                    <div class="col-6">
                    <form class="navbar-search">
                        <div class="form-group mb-0">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input class="form-control" placeholder="Search Reservation Code" name="code" type="text">
                            </div>
                        </div>
                    </form>
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

            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Reservation Code</th>
                    <th scope="col">User</th>
                    <th scope="col">Total Pax</th>
                    <th scope="col">Spaces Choosen</th>
                    <th scope="col">Reservation Time</th>
                    <th scope="col">Reservation Status</th>
                    <th scope="col">Submited On</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($data as $dt)
                  <tr>

                    <td>
                    {{$dt->reservation_code}}
                    </td>
                    <td>
                       {{ $dt->user->gender == 0  ? "Mr." : "Mrs."}} {{$dt->user->name}}
                    </td>
                    <td>{{$dt->total_pax}}</td>
                    <td>
                      {{ $dt->space->name }}
                    </td>
                    <td>
                      {{\Carbon\Carbon::parse($dt->reservation_datetime)->format('d-m-Y H:i')}}
                    </td>
                    <td>
                      @if($dt->payment_status == -1)
                        <span class="badge badge-pill badge-info">Waiting For Payment</span>
                        @elseif($dt->payment_status == 0)
                          <span class="badge badge-pill badge-warning">Upcoming</span>
                        @elseif($dt->payment_status == -2)
                          <span class="badge badge-pill badge-danger">Cancelled</span>
                        @elseif($dt->payment_status == 1)
                          <span class="badge badge-pill badge-default">Not Coming</span>
                        @elseif($dt->payment_status == 2)
                          <span class="badge badge-pill badge-success">Completed</span>
                      @endif
                    </td>
                    <td>
                      {{\Carbon\Carbon::parse($dt->created_at)->format('d F Y H:i')}}
                    </td>
                    <td class="">
                      @if($dt->payment_status >= 0 && $dt->payment_status != 2)
                      @if(Auth::user()->role == 2 )
                      @if($dt->reservation_datetime <= \Carbon\Carbon::now()->format('Y-m-d H:i:s'))

                    <a class="btn btn-sm text-white btn-info" href="{{route('reservation.summary',$dt->reservation_code)}}">
                      Mark as Served
                      </a>
                      @endif
                      @else
                  <a class="btn btn-sm text-white btn-info" href="{{route('reservation.summary',$dt->reservation_code)}}">
                      See Detail
                    </a>
                      @endif
                    @else
                  <a class="btn btn-sm text-white btn-default width-100" href="{{route('reservation.summary',$dt->reservation_code)}}">
                    Show Detail
                  </a>
                    @endif
                    @if(\Carbon\Carbon::parse($dt->reservation_datetime)->diffInMinutes(\Carbon\Carbon::now()) >= "30")
                    @if(Auth::user()->role == 2)
                    @if($dt->payment_status == 0 )
                    @if($dt->reservation_datetime <= \Carbon\Carbon::now()->format('Y-m-d H:i:s'))
                    <a class="btn btn-sm text-white btn-warning" href="{{route('reservation.run',$dt->id)}}">
                      Not Show Up
                    </a>
                    @endif
                    @endif
                    @endif
                    @endif
                    </td>
                  </tr>
                  @endforeach

                </tbody>
              </table>
            </div>
            <div class="card-footer py-4">
              <nav aria-label="...">
              {!! $data->links() !!}
              </nav>
            </div>
          </div>
        </div>
      </div>
@endsection
