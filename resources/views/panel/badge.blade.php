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
                    <h3 class="mb-3">Our Restaurant Badges</h3>
                    <a href="{{route('badge.create')}}" class="btn btn-primary btn-sm"> Add New Badge</a>
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
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                @foreach($data as $dt)
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                        <a href="#" class="avatar rounded-circle mr-3">
                          <img alt="Image placeholder" src="{{url('/images/badges/'.$dt->image)}}">
                        </a>
                        <div class="media-body">
                          <span class="mb-0 text-sm">{{$dt->name}}</span>
                        </div>
                      </div>
                    </th>
                    <td>
                      <div class="d-flex align-items-center">
                      <span class="badge badge-dot mr-4">
                        <i class="{{$dt->status==1?'bg-success':'bg-danger'}}"></i> {{$dt->status==1?"Active":"Deactive"}}
                      </span>
                      </div>
                    </td>
                    <td class="text-right">
                      <div class="dropdown">
                        <a class="btn btn-sm btn-warning btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                          <a class="dropdown-item" href="{{route('badge.edit',$dt->id)}}">Edit Data</a>
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
