@extends('panel.layout.app')
@section("page_name") Dashboard @endsection
@section('content')
    <!-- Table -->
    <div class="container-fluid mt--7">
<div class="row">
  @foreach ($errors->all() as $message)
  <div class="col-md-12">
  <div class="alert alert-danger" role="alert">
  Error! <strong>{{$message}}</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
  </button>
  </div>
</div>
  @endforeach
</div>
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
            <form action="{{route('reservation.generate')}}" method="POST" target="_blank">
              @csrf
                <div class="row">
                    <div class="col-6">
                    <h3 class="mb-3">Generate Reservation Report</h3>
                    </div>
                </div>

                <div class="row">
                  @foreach ($errors->all() as $message)
                  @endforeach
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
              <div class="col-md-4">
                <div class="form-group">
                  <label>Start Date</label>
                  <input type="text" name="start_date" placeholder="Choose Start Date" class="form-control datepicker" readonly>
                </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label>End Date</label>
                    <input type="text" name="end_date" placeholder="Choose End Date" class="form-control datepicker" readonly>
              </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                  <label>Reservation Status</label>
                  <select name="status" class="form-control">
                  <option value="">- All Status</option>
                  <option value="-2">Cancelled</option>
                  <option value="-1">Waiting for Payment</option>
                  <option value="0">Upcoming Reservation</option>
                  <option value="1">User not showing Up</option>
                  <option value="2">Reservation Completed</option>
                </select>
            </div>
          </div>
          </div>
        </div>
            <div class="card-footer py-4">
              <button class="btn btn-primary" target="_blank">Generate Report</button>
            </div>
          </div>
        </div>
      </form>
      </div>
      <div class="row mt-3">
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
              <form action="{{route('reservation.DPgenerate')}}" method="POST" target="_blank">
                @csrf
                  <div class="row">
                      <div class="col-6">
                      <h3 class="mb-3">Generate Down Payment Report</h3>
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
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Start Date</label>
                    <input type="text" name="start_date" placeholder="Choose Start Date" class="form-control datepicker" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <label>End Date</label>
                      <input type="text" name="end_date" placeholder="Choose End Date" class="form-control datepicker" readonly>
                </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label>Payment Channel</label>
                    <select name="status" class="form-control">
                    <option value="">- All Payment</option>
                    <option value="VISA">VISA</option>
                    <option value="MASTERCARD">MASTERCARD</option>
                  </select>
              </div>
            </div>
            </div>
          </div>
              <div class="card-footer py-4">
                <button class="btn btn-primary" target="_blank">Generate Report</button>
              </div>
            </div>
          </div>
        </form>
        </div>
    </div>
@endsection
