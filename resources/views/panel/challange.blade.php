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
                    <h3 class="mb-3">Our System Challanges</h3>
                    <a href="{{route('challange.create')}}" class="btn btn-primary btn-sm"> Make a Challange</a>
                    </div>
                    <div class="col-6">
                    <!-- <form class="navbar-search">
                        <div class="form-group mb-0">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input class="form-control" placeholder="Search" type="text">
                            </div>
                        </div>
                    </form> -->
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
                    <th scope="col">Challange Type</th>
                    <th scope="col">Multiple Allowed</th>
                    <th scope="col">Challange Parameter</th>
                    <th scope="col">Reservation Status</th>
                    <th scope="col">Reward</th>
                    <th scope="col">Status</th>
                    <th scope="col">...</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($data as $dt)
                  <tr>
                    <td>
                        {{$dt->type}}
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-dot mr-4">
                              <i class="{{$dt->is_multiple==1?'bg-success':'bg-danger'}}"></i> {{$dt->is_multiple==1?"Yes":"No"}}
                            </span>
                        </div>
                    </td>
                    <td>
                      <ul style="list-style-type:circle;">
                        @if($dt->min_transaction)
                          <li>Min Transaction : {{$dt->min_transaction}}</li>
                        @endif
                      @if($dt->reservation_date)
                        <li>Reservation Made for : {{$dt->reservation_date}}</li>
                        @endif
                      @if($dt->reservation_required)
                        <li>Atleast User make : {{$dt->reservation_required }} Reservation</li>
                        @endif
                      @if($dt->total_spend)
                        <li>Total Spend : IDR. {{ number_format($dt->total_spend) }}</li>
                        @endif
                      @if($dt->is_multiple_reservation)
                        <li>Allow Multiple Reservation : {{ $dt->is_multiple_reservation ? "Yes":"No" }}</li>
                        @endif
                      </ul>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-dot mr-4">
                              @if($dt->payment_status == 0)
                                <span class="badge badge-pill small badge-info">On Held</span>
                                @elseif($dt->payment_status == 2)
                                  <span class="badge badge-pill small badge-success">Completed</span>
                              @endif
                            </span>
                        </div>
                    </td>

                    <td>
                      <ul style="list-style-type:circle">
                      @if($dt->reward->id_badge)
                      <li>Badge : {{$dt->reward->badge->name }}</li>
                      @endif
                      @if($dt->reward->point)
                      <li>Points : {{$dt->reward->point}} {{$dt->reward->point_type == "FLAT" ? "" : "% from Total Reservation"}}</li>
                      @endif
                    </ul>
                    </td>
                    <td><span class='small {{$dt->status ==0 ? "badge badge-danger":"badge badge-success"}}'>{{$dt->status ==0 ? "Deactive" : "Active" }}</td>
                    <td class="text-right">
                      <div class="dropdown">
                        <a class="btn btn-sm btn-warning btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                          <a class="dropdown-item" href="{{route('challange.edit',$dt->id)}}">Edit Data</a>
                        </div>
                      </div>
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
