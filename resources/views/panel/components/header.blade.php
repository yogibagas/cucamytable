<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    @yield('page_title','Cuca My Table Panel')
  </title>
  <!-- Favicon -->
  <link href="{{url('/assets/img/brand/favicon.png')}}" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="{{url('/assets/js/plugins/nucleo/css/nucleo.css')}}" rel="stylesheet" />
  <link href="{{url('/assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="{{url('/assets/css/argon-dashboard.css?v=1.1.0')}}" rel="stylesheet" />
  <link href="{{url('/assets/css/timepicker.min.css')}}" rel="stylesheet" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="">
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="{{url('/panel')}}">
        <img src="{{url('/images/Cuca_logo-2.png')}}" class="navbar-brand-img" alt="...">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-bell-55"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                   @if(Auth::user()->gender==1)
                  <img alt="Image placeholder" src="{{url('images/male-avatar.jpeg')}}">
                    @else
                  <img alt="Image placeholder" src="{{url('images/female-avatar.jpeg')}}">
                  @endif
              </span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <a href={{'/panel/user/'.Auth::user()->id}} class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span>My profile</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#!" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
          </div>
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="{{url('/panel')}}">
                <img src="{{url('/images/Cuca_logo-2.png')}}">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>

        <!-- Navigation -->

        <!-- Divider -->
        <!-- Heading -->
        <h6 class="navbar-heading text-muted">
          <span>{{Auth::user()->username}}</span>
            <span class="badge badge-default float-right text-white">{{number_format(Auth::user()->points->sum->points)}} Points</span>
        </h6>
        <h6 class="navbar-heading text-muted">My Dashboard</h6>
        <hr class="my-2">
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link " href="{{route('dashboard')}}">
              <i class="ni ni-collection text-orange"></i> Dashboard
            </a>
          </li>
        @if(Auth::user()->role == 1 || Auth::user()->role == 0 )
        <!-- Navigation -->
          <li class="nav-item">
            <a class="nav-link " href="{{route('challange.list')}}">
              <i class="fa fa-trophy text-blue"></i>
              <span> Challange List</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{route('badge.list')}}">
              <i class="fa fa-trophy text-orange"></i>
              <span>My Badges</span>
              <span class="badge badge-danger ml-3">{{ $notification['badge'] ?? null }}</span>
            </a>
          </li>
          @endif
          @if(Auth::user()->role == 0)
          <li class="nav-item">
            <a class="nav-link " href="{{route('badge.index')}}">
              <i class="ni ni-badge text-orange"></i> Badges List
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{route('reward.index')}}">
              <i class="ni ni-trophy text-orange"></i> Reward List
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{route('challange.index')}}">
              <i class="ni ni-controller text-orange"></i> Challanges List
            </a>
          </li>
          @endif
        </ul>
        @if(Auth::user()->role == 0)
        <hr class="my-1">
        <h6 class="navbar-heading text-muted">Restaurant Master</h6>
        <hr class="my-1">
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
        <li class="nav-item">
            <a class="nav-link " href="{{route('space.index')}}">
              <i class="ni ni-spaceship text-blue"></i> Spaces
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{route('menu')}}">
              <i class="ni ni-collection text-blue"></i> Menu
            </a>
          </li>
        </ul>
        @endif

        <hr class="my-3">
        <h6 class="navbar-heading text-muted">Reservation Data</h6>
        <hr class="my-2">
        <ul class="navbar-nav">
        @if(Auth::user()->role == 2)
        <li class="nav-item">
          <a class="nav-link " href="{{route('reservation.index')}}">
            <i class="ni ni-books text-blue"></i> Upcoming Today
            <span class="badge badge-default ml-3">{{ $notification['reservation'] ?? null }}</span>
          </a>
        </li>
        @endif
          @if(Auth::user()->role == 0 || Auth::user()->role == 2)
          <li class="nav-item">
            <a class="nav-link " href="{{Auth::user()->role == 2 ? route('reservation.all') : route('reservation.index')}}">
              <i class="ni ni-pin-3 text-orange"></i> {{ Auth::user()->role ==2 ?"All Reservation":"Reservation Data"}}
            </a>
          </li>
          @endif
          @if(Auth::user()->role == 1)
            <li class="nav-item">
              <a class="nav-link " href="{{route('reservation.list')}}">
                <i class="ni ni-pin-3 text-orange"></i> My Reservation
              </a>
            </li>
            @endif
        </ul>
        @if(Auth::user()->role ==0 || Auth::user()->role == 1)
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <!-- <h6 class="navbar-heading text-muted">Report</h6> -->
        <!-- Navigation -->

        <h6 class="navbar-heading text-muted">Leaderboard & Logs</h6>
        <hr class="my-2">
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link " href="{{route('leaderboards')}}">
              <i class="fa fa-trophy text-orange"></i>
              <span>Leaderboard</span>
            </a>
          </li>

            <li class="nav-item">
              <a class="nav-link " href="{{route('point.log')}}">
                <i class="ni ni-collection text-orange"></i> Point Logs
              </a>
            </li>
          </ul>
            @endif

            @if(Auth::user()->role ==0)
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            <!-- <h6 class="navbar-heading text-muted">Report</h6> -->
            <!-- Navigation -->

            <h6 class="navbar-heading text-muted">Users Data</h6>
            <hr class="my-2">
            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
              <li class="nav-item">
                <a class="nav-link " href="{{route('user.index')}}">
                  <i class="fa fa-users text-red"></i>
                  <span>Users</span>
                </a>
              </li>

              </ul><!-- Divider -->
              <hr class="my-3">
              <!-- Heading -->
              <!-- <h6 class="navbar-heading text-muted">Report</h6> -->
              <!-- Navigation -->

              <h6 class="navbar-heading text-muted">Reports Generator</h6>
              <hr class="my-2">
              <!-- Navigation -->
              <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                  <a class="nav-link " href="{{route('user.reports')}}">
                    <i class="fa fa-book text-brown"></i>
                    <span>Users</span>
                  </a>
                </li>

                  <li class="nav-item">
                    <a class="nav-link " href="{{route('menu.reports')}}">
                      <i class="fa fa-book text-brown"></i>
                      <span>Ordered Menu</span>
                    </a>
                  </li>

                    <li class="nav-item">
                      <a class="nav-link " href="{{route('reservation.reports')}}">
                        <i class="fa fa-book text-brown"></i>
                        <span>Reservation</span>
                      </a>
                    </li>

                </ul>
                @endif
      </div>
    </div>


  </nav>
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="@yield('page_link','#')">@yield("page_name")</a>
        <!-- Form -->

        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                    @if(Auth::user()->gender==1)
                  <img alt="Image placeholder" src="{{url('images/male-avatar.jpeg')}}">
                    @else
                  <img alt="Image placeholder" src="{{url('images/female-avatar.jpeg')}}">
                  @endif
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold">@if(Auth::user()) {{ Auth::user()->username}} @else {{'Username'}} @endif</span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <div class=" dropdown-header noti-title">
                <h6 class="text-overflow m-0">Welcome!</h6>
              </div>

              <a href={{'/panel/user/'.Auth::user()->id}} class="dropdown-item">
                <i class="ni ni-single-02"></i>
                <span>My profile</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="{{ route('logout') }}"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item">

                <i class="ni ni-user-run"></i>
                {{ __('Logout') }}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <!-- <div class="row">
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Reservation this month</h5>
                      <span class="h2 font-weight-bold mb-0">350,897</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-chart-bar"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                    <span class="text-nowrap">Since last month</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">New users this week</h5>
                      <span class="h2 font-weight-bold mb-0">2,356</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-chart-pie"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span>
                    <span class="text-nowrap">Since last week</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Sale this month</h5>
                      <span class="h2 font-weight-bold mb-0">924</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                    <span class="text-nowrap">Since yesterday</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Highest User Points This Year</h5>
                      <span class="h2 font-weight-bold mb-0">983.457</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-percent"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-nowrap"><a href="#">View User</a></span>
                  </p>
                </div>
              </div>
            </div>
          </div> -->
        </div>
      </div>
    </div>
