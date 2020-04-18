@extends('panel.layout.app')
@section('page_name') Restaurant Menu @endsection
@section('page_link') {{route('menu')}} @endsection
@section('content')
<div class="container-fluid mt--7">

      <div class="row">
        <div class="col">
            <div class="card shadow">
            <div class="card-header border-0">
              <h3 class="mb-0">Form Reward</h3>
            </div>
                <form class="pl-4 pr-4" method="POST" action="{{$data->exists ? route('reward.update',$data->id) : route('reward.store')}}" enctype="multipart/form-data">
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
                        <div class="col-md-4">
                        <div class="form-group">
                            <label>Point Type<small>(Choose point reward type Flat or %)</small></label>
                            <div class="form-group">
                                <select name="point_type" class="form-control" id="point_type">
                                    <option value="FLAT" {{$data->point_type == "FLAT" ? "selected" : false}}>FLAT POINTS</option>
                                    <option value="PERCENTAGE" {{$data->point_type == "PERCENTAGE" ? "selected" : false}}>PERCENTAGE (%)</option>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            <label>Point Rewards<small>(use . as a decimal symbol)</small></label>
                            <div class="form-group">
                                <div class="input-group">
                                <input class="form-control" placeholder="How much point user get" type="text" name="point" value="{{$data->point}}">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="point_text" >Points</span>
                                </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            <label>Max Points <small>(Put Maximum points can user get)</small></label>
                            <div class="form-group">
                            <div class="input-group">
                                    <input type="number" placeholder="Maximum points user can get" class="form-control" name="max_point" value="{{$data->max_point}}">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">Points</span>
                                </div>
                            </div>
                            </div>

                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3" id="badge">
                        <input type="checkbox" class="" id="badges" name="badge" {{$data->id_badge == null ? false:"checked"}}>
                        <label for="badges">This Reward is get a badge</label>
                        </div>
                        <div class="col-md-9" id="badgeReward">
                            <div class="badgeReward" >
                            <label>Choose Badge as a Reward</label>
                            <div class="form-group">
                                <select class="form-control" name="id_badge" id="id_badge">
                                <option value="" {{$data->id_badge == null ? "selected":false}}>-- Select the badge</option>
                                @foreach($badge as $b)
                                <option value="{{$b->id}}" {{$data->id_badge == $b->id ? "selected":false}}>{{$b->name}}</option>
                                @endforeach
                                </select>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Status</labeL>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" name="status" class="" checked value="1" {{$data->exists && $data->status == 1 ? 'Checked': false}} > Active
                                <input type="radio" name="status" class="ml-2" value="0" {{$data->exists && $data->status == 0 ? 'Checked': false}}> Deactive
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

@push('scripts')
<script>
    $(document).ready(function(){
        if($("#point_type").val() == "FLAT")
            $("#point_text").html("POINTS");
            else
            $("#point_text").html("%")

        if($("#badges").is(':checked')){
        $("#badgeReward").show();
    }else{
        $("#badgeReward").hide();
        $("#id_badge").val("");
    }

        $("#point_type").on('change',function(){
            if($(this).val() == "FLAT")
            $("#point_text").html("POINTS");
            else
            $("#point_text").html("%")
        });
    });
$(document).ready(function(){
});
$("#badges").click(function(){
    if($(this).is(':checked')){
        $("#badgeReward").show();
    }else{
        $("#badgeReward").hide();
        $("#id_badge").val("");
    }
});
</script>
@endpush
