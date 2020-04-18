@extends('panel.layout.app')
@section('page_name') Restaurant Spaces @endsection
@section('page_link') {{route('space.index')}} @endsection
@section('content')
<div class="container-fluid mt--7">

      <div class="row">
        <div class="col">
            <div class="card shadow">
            <div class="card-header border-0">
              <h3 class="mb-0">Form Spaces</h3>
            </div>
                <form class="pl-4 pr-4" method="POST" action="{{$data->exists ? route('space.update',$data->id) : route('space.store')}}" enctype="multipart/form-data">
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
                            <label>Space Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" placeholder="Spaces Name" name="name" {{$data->exists ? "readonly" : false}} value="{{$data->name}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Minimum Pax</label>
                                <input type="number" id="avaibility" placeholder="Minimum Pax to get the spaces" class="form-control" value="{{$data->minimum_pax}}"  name="minimum_pax"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Maximum Pax </label>
                                <input type="number" id="maximum_pax" placeholder="Maximum Pax" class="form-control"  name="maximum_pax" value="{{$data->maximum_pax}}" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Avaibility <small>(Put your spaces avaibility)</small></label>
                                <input type="number" id="avaibility" placeholder="Spaces Avaibility" class="form-control"  name="avaibility" value="{{$data->avaibility}}" />
                            </div>
                        </div>

                    </div>

                    <div class="row">
                            <div class="col-md-8">
                                <label>Images<small> {{ $data->exists ? '(Leave it empty if you don\'t want to change the image. Size Allowed : 1Mb)' : '(File allowed : jpeg/jpg/png only no more than 1Mb)' }}</small></label>
                                <div class="form-group">
                                    <input type="file" class="form-control" name="images">
                                </div>
                            </div>
                        <div class="col-md-4">
                            <label>Status</labeL>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" name="status" class="" {{$data->exists && $data->status == 1 ? 'Checked': 'checked'}}  value="1">Active
                                <input type="radio" name="status" class="ml-2" value="0" {{$data->exists && $data->status == 0 ? 'Checked': false}}> Deactive
                            </div>
                        </div>
                            <div class="col-md-12">
                                <label>Description<small> </small></label>
                                <div class="form-group">
                                    <textarea name="desc" class="form-control" style="min-height:80px" placeholder="write space description here">{{$data->desc}}</textarea>
                                </div>
                            </div>

                    </div>
                    <div class="card-footer text-right">
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success">
                                    </div>
                                </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
