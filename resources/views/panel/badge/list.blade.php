@extends('panel.layout.app')
@section("page_name") Dashboard @endsection
@section('content')
    <!-- Table -->
    <div class="container-fluid mt--7">

    <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
                <div class="row">
                    <div class="col-6">
                    <h3 class="mb-3">Your Badges</h3>
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
              @foreach($collection as $badges)
              <div class="col-md-1 text-center p-2 ml-3">
                <div class="bdg blue-dark" data-toggle="tooltip" data-placement="bottom" title="{{$badges->name}}">
                  <div class="circle">
                    <img src="{{url('images/badges/'.$badges->image)}}" class="img-fluid">
                  </div>
              </div>
                <br>
                <span class="badge badge-info mt-3">{{$badges->name}}</span>
              </div>
              @endforeach
          </div>
        </div>
        </div>
        </div>
      </div>

    </div>

    <div class="container-fluid mt-7">

    <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
                <div class="row">
                    <div class="col-6">
                    <h3 class="mb-3">Cuca Badge List</h3>
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
              @foreach($list as $badges)
              <div class="col-md-1  text-center p-2 ml-3">
                <div class="bdg {{!in_array($badges->id,$collectionList) ? "silver":"blue-dark" }}" data-toggle="tooltip" data-placement="bottom" title="{{$badges->name}}">
                  <div class="circle">
                    <img src="{{url('images/badges/'.$badges->image)}}" class="img-fluid">
                  </div>
              </div>
                <br>
                <span class="badge badge-info mt-3">{{$badges->name}}</span>
              </div>
              @endforeach
          </div>
        </div>
        </div>
        </div>
      </div>

    </div>
@endsection
