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
            <form action="{{route('user.generate')}}" method="POST" target="_blank">
              @csrf
                <div class="row">
                    <div class="col-6">
                    <h3 class="mb-3">Generate Users Report</h3>
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
              <div class="col-md-3">
                <div class="form-group">
                  <label>Role</label>
                  <select name="role" class="form-control">
                  <option value="">- All Role</option>
                  <option value="0">Admin</option>
                  <option value="1">Member</option>
                  <option value="2">Cashier</option>
                </select>
                </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" class="form-control">
                    <option value="">- All Gender</option>
                    <option value="0">Male</option>
                    <option value="1">Female</option>
                  </select>
              </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                  <label>Country</label>
                  <select name="country" class="form-control">
                  <option value="">- All Countries</option>
                  @foreach($country as $c)
                  <option value="{{$c->id}}">{{$c->nicename}}</option>
                  @endforeach
                </select>
            </div>
          </div>
          <div class="col-md-3">
              <div class="form-group">
                <label>User Status</label>
                <select name="status" class="form-control">
                <option value="">- All Status</option>
                <option value="1">Activate</option>
                <option value="0">Suspended</option>
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
@endsection
