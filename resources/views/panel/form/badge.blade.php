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
                <form class="pl-4 pr-4" method="POST" action="{{$data->exists ? route('badge.update',$data->id) : route('badge.store')}}" enctype="multipart/form-data">
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
                            <label>Badge Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" placeholder="Badge Name" name="name" value="{{$data->name}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Status</labeL>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" name="status" class="" checked value="1" {{$data->exists && $data->status == 1 ? 'Checked': 'checked'}} > Active
                                <input type="radio" name="status" class="ml-2" value="0" {{$data->exists && $data->status == 0 ? 'Checked': false}}> Deactive
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label>Badge Icon <small>{{!$data->exists ? "(Put your badge icon here , allowed file : png only and max 1Mb)" : "(left empty if not want change the image, allowed file : png only and max 1Mb)" }}</small></label>
                            <div class="form-group">
                                    <input type="file" class="form-control" name="badge_image">
                                </div>
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
