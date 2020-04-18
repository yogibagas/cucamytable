@extends('panel.layout.app')
@section('page_name') Restaurant Menu @endsection
@section('page_link') {{route('menu')}} @endsection
@section('content')
<div class="container-fluid mt--7">

      <div class="row">
        <div class="col">
            <div class="card shadow">
            <div class="card-header border-0">
              <h3 class="mb-0">Form Badge</h3>
            </div>
                <form class="pl-4 pr-4" method="POST" action="{{$data->exists ? route('user.update',$data->id) : route('user.store')}}" enctype="multipart/form-data">
                @foreach ($errors->all() as $message)
                <div class="alert alert-danger" role="alert">
                Error! <strong>{{$message}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </button>
            </div>
                @endforeach
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
                @elseif($message = Session::get('failed'))
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @endif
                {{ $data->exists ? method_field('PUT') : method_field('POST') }}
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label>Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" placeholder="User fullname" name="name" value="{{$data->name}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Username</label>
                            <div class="form-group">
                                <input type="text" class="form-control" {{$data->exists ? "readonly" : false}} id="username" placeholder="Username (for login purpose)" name="username" value="{{$data->username}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Email</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" placeholder="User Email Address" name="email" value="{{$data->email}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Password</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="password" placeholder="User Password {{$data->exists ? "(Leave empty if dont want change the password)" : ""}}" name="password" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Phone</label>
                            <div class="form-group">
                                <input type="number" class="form-control" id="password" placeholder="Phone Number" name="phone" value="{{$data->phone}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Gender</label>
                            <div class="form-group">
                                <select name="gender" class="form-control">
                                <option value="0" {{$data->gender == 0 ? "selected" : false}}>Male</option>
                                <option value="1" {{$data->gender == 1 ? "selected" : false}}>Female</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Role</label>
                            <div class="form-group">
                                <select name="role" class="form-control">
                                <option value="0" {{$data->role == 0 ? "selected" : false}}>Admin</option>
                                <option value="1" {{$data->role == 1 ? "selected" : false}}>Member</option>
                                <option value="2" {{$data->role == 2 ? "selected" : false}}>Cashier</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Status</labeL>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" name="status" class="" checked value="1" {{$data->exists && $data->status == 1 ? 'Checked': 'checked'}} > Active
                                <input type="radio" name="status" class="ml-2" value="0" {{$data->exists && $data->status == 0 ? 'Checked': false}}> Suspend
                            </div>
                        </div>
                    </div>

                    <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success">
                                </div>
                            </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
