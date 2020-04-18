@extends('panel.layout.app')
@section('page_name') Restaurant Menu @endsection
@section('page_link') {{route('menu')}} @endsection
@section('content')
<div class="container-fluid mt--7">

      <div class="row">
        <div class="col">
            <div class="card shadow">
            <div class="card-header border-0">
              <h3 class="mb-0">Form Create</h3>
            </div>
                <form class="pl-4 pr-4" method="POST" action="{{$data->exists ? route('menu.update',$data->id) : route('menu.store')}}" enctype="multipart/form-data">
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
                            <label>Menu Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" placeholder="Menu Name" name="name" value="{{$data->name}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label>Price <small>(Price are in IDR following the goverment policy)</small></label>
                            <input type="text" id="price" placeholder="Menu Price" class="form-control"  name="price" value="{{$data->price}}"/>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Category</label>
                        <div class="form-group" >
                            <select class="form-control" name="id_category">
                                @foreach($category as $ct)
                                <option value="{{$ct->id}}" {{$ct->id == $data->id_category ? "Selected": false}}>{{$ct->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                        <div class="col-md-3">
                            <label>Status</labeL>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" name="status" class="" checked value="1" {{$data->exists && $data->status == 1 ? 'Checked': 'checked'}} >Active
                                <input type="radio" name="status" class="ml-2" value="0" {{$data->exists && $data->status == 0 ? 'Checked': false}}> Deactive
                            </div>
                        </div>

                    </div>

                    <div class="row">
                            <div class="col-md-12">
                                <label>Images<small> {{ $data->exists ? '(Leave it empty if you don\'t want to change the image. Max Size Allowed : 1Mb)' : '(File allowed : jpeg/jpg/png only no more than 1Mb)' }}</small></label>
                                <div class="form-group">
                                    <input type="file" class="form-control" name="menu_images">
                                </div>
                            </div>
                    </div>
                    <div class="row">
                            <div class="col-md-12">
                                <label>Description</label>
                                <div class="form-group">
                                <textarea name="desc" class="form-control">{{$data->exists ? $data->desc : ""}}</textarea>
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
