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
            <form action="{{route('menu.generate')}}" method="POST" target="_blank">
              @csrf
                <div class="row">
                    <div class="col-6">
                    <h3 class="mb-3">Generate Ordered Menu Report</h3>
                    </div>
                </div>

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
                  <input type="text" name="start_date" placeholder="All Dates" class="form-control datepicker" readonly>
                </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label>End Date</label>
                    <input type="text" name="end_date" placeholder="All Dates" class="form-control datepicker" readonly>
              </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                  <label>Category</label>
                  <select name="category" class="form-control">
                  <option value="">- All Category</option>
                  @foreach($category as $c)
                  <option value="{{$c->id}}">{{$c->name}}</option>
                  @endforeach
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
