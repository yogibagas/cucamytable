@extends('panel.layout.app')
@section('page_title') My Profile @endsection
@section('page_name') My Profile @endsection
@section('content')
    <!-- Header -->
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url('{{url('/images/cuca-bg.jpg')}}'); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-default opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid d-flex align-items-center">
          <div class="col-lg-7 col-md-10">
            <h1 class="display-2 text-white">Hi </h1>
            <p class="text-white mt-0 mb-5">{{ Auth::user()->id != $user->id ? "Welcome to ". $user->name ." profile" : "This is Your Profile"}}</p>
          </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="card card-profile shadow">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <a href="#">
                    <img src="{{ $user->gender == 0 ? url("/images/male-avatar.jpeg") : url("/images/female-avatar.jpeg")}}" class="rounded-circle">
                  </a>
                </div>
              </div>
            </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
              <div class="d-flex justify-content-between">
              </div>
            </div>
            <div class="card-body pt-0 pt-md-4">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                    <div>
                      <span class="heading">{{$user->reservation->count()}}</span>
                      <span class="description">Reservation</span>
                    </div>
                    <div>
                      <span class="heading">{{$user->points->sum('points')}}</span>
                      <span class="description">Points</span>
                    </div>
                    <div>
                      <span class="heading">{{$user->badge->count()}}</span>
                      <span class="description">Badges</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="text-center">
                <h3>
                {{$user->name}}<span class="font-weight-light"></span>
                </h3>
                <div class="h5 font-weight-300">
                  {{ Auth::user()->id == $user->id ? $user->email : ""}}
                </div>
                <div class="h5 mt-4">
                  <i class="ni business_briefcase-24 mr-2"></i>{{$user->country->nicename}} - {{$user->country->iso}}
                </div>
                <div>
                  <i class="ni education_hat mr-2"></i>
                    {{ Auth::user()->id == $user->id ? $user->phone : ""}}
                </div>
                <hr class="my-4" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-8 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">{{Auth::user()->id == $user->id ? "My Account" : "Account Detail"}}</h3>
                </div>
                <div class="col-4 text-right">
                </div>
              </div>
            </div>
            <div class="card-body">
              <form>
                <h6 class="heading-small text-muted mb-4">User information</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Name</label>
                        <input type="text" id="input-username" readonly class="form-control form-control-alternative" placeholder="Username" value="{{$user->name}}">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Email address</label>
                        <input type="email" id="input-email" readonly class="form-control form-control-alternative" placeholder="{{$user->email}}">
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4" />
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">Badge Collection</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    @foreach($badge as $badges)
                    <div class="col-md-2 text-center p-2 ml-3">
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
                <hr class="my-4" />
                <h6 class="heading-small text-muted mb-4">Cuca Badge List</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    @foreach($badgeList as $badges)
                    <div class="col-md-2 text-center p-2 ml-3">
                      <div class="bdg silver" data-toggle="tooltip" data-placement="bottom" title="{{$badges->name}}">
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
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <footer class="footer">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-6">
            <div class="copyright text-center text-xl-left text-muted">
              &copy; {{date('Y')}} <a href="https://www.cucabali.com" class="font-weight-bold ml-1" target="_blank">Cuca Bali</a>
            </div>
          </div>
          <div class="col-xl-6">
            <ul class="nav nav-footer justify-content-center justify-content-xl-end">
              <li class="nav-item">
                <a href="https://www.cucabali.com" class="nav-link" target="_blank">Our Website</a>
              </li>
              <li class="nav-item">
                <a href="https://www.giftvoucher.cucabali.com" class="nav-link" target="_blank">Giftvoucher</a>
              </li>
              <li class="nav-item">
                <a href="http://china.cucabali.com" class="nav-link" target="_blank">China Menu</a>
              </li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>
@endsection
