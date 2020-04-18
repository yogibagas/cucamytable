@extends('panel.layout.app')
@section('page_name') Restaurant Challange @endsection
@section('page_link') {{route('challange.index')}} @endsection
@section('content')
<div class="container-fluid mt--7">

      <div class="row">
        <div class="col">
            <div class="card shadow">
            <div class="card-header border-0">
              <h3 class="mb-0">Form Challange</h3>
            </div>
                <form class="pl-4 pr-4" method="POST" action="{{$data->exists ? route('challange.update',$data->id) : route('challange.store')}}" enctype="multipart/form-data">
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
                            <div class="form-group">
                                <label>Challange Type <small>(Choose action to trigger this challange)</small></label>
                                <div class="form-group">
                                    <select name="type" class="form-control" id="type">
                                       <option value="RESERVATION" {{old('type') == "RESERVATION" ? "selected":false}}>When User Make Reservation</option>
                                       <option value="SPECIALDAY"{{old('type') == "SPECIALDAY" ? "selected":false}}>When User Make Reservation on Special Day</option>
                                       <option value="TOTALSPEND"{{old('type') == "TOTALSPEND" ? "selected":false}}>When User Make Reservation with Total Spend</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label>Choose Reward<small>(Choose reward for this challange)</small></label>
                            <div class="form-group">
                                <select name="id_reward" class="form-control" id="id_reward">
                                   <option value="">-- Choose the reward for reservation</option>
                                   @foreach($reward as $rwd)
                                   <option value="{{$rwd->id}}" {{old('id_reward') == $rwd->id ? "selected":false}}>User will get :
                                       {{$rwd->id_badge!=null?$rwd->badge->name." Badge":false}}
                                       {{$rwd->id_badge && $rwd->point >0 ? "AND" : false}}
                                       {{$rwd->point>0 ? $rwd->point:false}}
                                       {{$rwd->point>0 ? $rwd->point_type == "PERCENTAGE" ? "% Points from Total Pay":" Points" : false}}
                                       </option>
                                   @endforeach
                                </select>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header " id="reward">
                                    <div class"row">
                                        <h4 class="mb-0">Detail Challanges</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row" >
                                        <div class="col-md-6" id="special_date">
                                            <div class="form-group">
                                            <label>User must make a reservation on </label>
                                                <div class="input-group input-group-alternative">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                    </div>
                                                    <input class="form-control datepicker" data-date-start-date="+1d" id="reservation_date" name="reservation_date" placeholder="Select date" type="text" value="{{old('reservation_date')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="min_transaction" style="display:none;">
                                            <div class="form-group">
                                                <label>Minimum Spend</label>
                                                <input type="number" name="min_transaction" value="{{old('min_transaction')}}" value=0  class="form-control" placeholder="put the minimum spend value here">
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="reservation_required">
                                        <div class="form-group">
                                            <label>How Many Reservation Must User Make</label>
                                            <select name="reservation_required" class="form-control" >
                                                @for($i=1;$i<=10;$i++)
                                                <option value="{{$i}}" {{old('reservation_required') == $i ? "selected":false}}>User must do {{$i}} {{$i == 1 ? "time" : "times"}} reservation</option>
                                                @endfor
                                            </select>
                                        </div>
                                        </div>
                                        <div class="col-md-6" id="total_spend">
                                        <div class="form-group">
                                            <label>Total Spend in Reservation</label>
                                            <input type="number" name="total_spend" value="{{old('total_spend')}}"  class="form-control" placeholder="put the total spend value here">
                                        </div>
                                        </div>

                                        <div class="col-md-6" id="is_multiple_reservation" >
                                            <div class="form-group">
                                                <label>Reservation type</label><br>
                                                <select name="is_multiple_reservation" class="form-control">
                                                    <option value="0" {{old('is_multiple_reservation') == 0 ? "selected":false}}>Single Reservation</option>
                                                    <option value="1" {{old('is_multiple_reservation') == 1 ? "selected":false}}>Multiple Reservation</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="reservation_status" >
                                            <div class="form-group">
                                                <label>Reservation Status on System Must Be : </label><br>
                                                <select name="reservation_status" class="form-control">
                                                    <option value="0" {{old('reservation_status') == 0 ? "selected":false}}> ON HELD</option>
                                                    <option value="2" {{old('reservation_status') == 2 ? "selected":false}}> COMPLETED</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card" >
                                <div class="card-header " >
                                    <div class"row">
                                        <h4 class="mb-0">Detail Reward</h4>
                                    </div>
                                </div>
                                <div class="card-body" id="reward_detail">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Allow user can done more than once for this challange </label>
                                <div class="form-group mt-4">
                                    <label class="custom-toggle" id="is_multiple">
                                    <input type="checkbox" name="is_multiple"  readonly="">
                                    <span class="custom-toggle-slider rounded-circle" readonly=""></span>
                                    </label>
                                    <label id="is_multiple_note"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Status</labeL>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" name="status" class="" checked value="1" {{$data->exists && $data->status == 1 ? 'Checked': 'checked'}} > Active
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
    // show reward


            $("#special_date").hide();
            $("#total_spend").hide();
            $("#is_multiple_reservation").hide();

    $("#type").on('change',function(){
        if($(this).val() == "RESERVATION"){
            $("#min_transaction").hide();
            $("#reservation_required").show();
            $("#special_date").hide();
            $("#total_spend").hide();
            $("#is_multiple_reservation").hide();
        }
        else if($(this).val() == "SPECIALDAY")
            {
            $("#special_date").show();
            $("#min_transaction").show();
            $("#total_spend").hide();
            $("#is_multiple_reservation").hide();
            $("#reservation_required").hide();
            }
        else if($(this).val() == "TOTALSPEND"){
            $("#total_spend").show();
            $("#is_multiple_reservation").show();
            $("#special_date").hide();
            $("#min_transaction").hide();
            $("#reservation_required").hide();

        }
        // $.ajax({
        //     type:"GET",
        //     url:'{{url("panel/reward/rewardlist")}}/'+$(this).val(),
        //     success(result){
        //         $("#id_reward").html('<option value="">-- Choose the reward for this challange </option>');
		// 						$("#reward_detail").html('');
        //         $.each(result,function(data,item){
        //             console.log(item);
        //             var label = "User will get : ";
        //         if(item.id_badge !=null )
        //         label += item.badge.name+' Badge ';
        //         if(item.id_badge !=null && item.point>0)
        //         label += "AND "

        //         if(item.point >0 )
        //         label += ''+item.point+" ";
        //         if(item.point_type == "PERCENTAGE")
        //         label += "% Points From Total Payment";
        //         else
        //         label += "Points";

        //         $("#id_reward").append(`<option value="`+item.id+`">`+label+`</option>`);
        //         });
        //     },
        // });
    }).change();
    $("#type").on('change',function(){

    $(this).closest('form').find("input[type=text], input[type=number]").val("");
    });
    //show detail rewards
    $("#id_reward").on('change',function(){
        if($(this).val().length > 0){
        var data = {
						"_token":$('meta[name="csrf-token"]').attr('content'),
						"id": $(this).val() ,
					};
        $.ajax({
						type:"GET",
						url:'{{url("panel/reward")}}/'+$(this).val(),
						data:data,
						success(result){
                            if(result.id_badge != null ){
                                $("#is_multiple").hide();
                                $("#is_multiple_note").html(`<small class="badge badge-danger">
                                this reward have a badge , this challange will counted a single challange , user cannot done multiple times for it.</small>`);
                            }else{
                                $("#is_multiple").show();
                                $("#is_multiple_note").html("");
                            }

								$("#reward_detail").html(`
								<div class="table-responsive ">
                                <table class="table align-items-center table-bordered table-dark" id="table-data">
                                    <thead class="thead-dark" id="t-head">

                                    </thead>
                                    <tbody class="list text-center" id="t-body">
                                    </tbody>
                                </table>
                                </div> `);
                                //table header sync
                                if(result.id_badge != null )
                                $("#t-head").append(`
                                        <th scope="col">Badge</th>`);

                                $("#t-head").append(`
                                        <th scope="col">Points</th>
                                        <th scope="col">Max Points</th>

                                `);
                                //table body sync
                                if(result.id_badge != null ){
                                $("#t-body").append(`
                                <th scope="row">
                                            <div class="bdg blue-dark" data-toggle="tooltip" data-placement="bottom" title="BadgeBadgeBadgeBadge Name">
                                                <div class="circle">
                                                     <img src="{{url('images/badges')}}/`+result.badge.image+`" class="img-fluid">
                                                </div>
                                            </div>
                                        </th>
                                `); }
                                var operator ="";
                                if(result.point_type == "PERCENTAGE")
                                 operator = "% From Total Spend";
                                else
                                 operator = "Points";
                                $("#t-body").append(`
                                <th scope="row">`+result.point+` `+operator+`
                                </th>
                                <th scope="row">`+result.max_point+` Points</th>
                                `);
						}
					});
        }
    }).change();
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
