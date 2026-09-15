@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')

<div class="container mt-4 mb-4">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center justify-content-center">
                Choose Mining Plan
            </div>
        </div>
        <div class="card-body">
        	<form action="{{ route('user.confirmed_plan') }}" method="post" id="percentageForm">
        	@csrf
            <div class="row">
            	<input type="hidden" name="url" value="{{ route('user.get_percentage') }}" id="GetPercentageUrl">
            		<div class="col-md-3">
            		    Plan
            		    <div class="form-group">
            		    	<select name="plan" class="form-control" id="UserPlan">
            		    		@foreach($plans as $plan)
            		    		<option value="{{$plan->value}}|{{$plan->title}}">{{$plan->title}}</option>
            		    		@endforeach
            		    	</select>
            		    </div>
            		</div>
            		<div class="col-md-3">
            		    Amount
            		    <div class="form-group">
            		    	<input type="number" name="amount" class="form-control" id="UserAmount" required="">
            		    </div>
            		</div>
            		<div class="col-md-3">
            		    Capital
            		    <div class="form-group">
            		    	<input type="number" class="form-control" id="CapitalAmount" readonly="">
            		    </div>
            		</div>
            		<div class="col-md-3">
            		    Net Proft
            		    <div class="form-group">
            		    	<input type="number" name="net_profit" class="form-control" id="percentageForResult" readonly="">
            		    </div>
            		    <p id="DailyInterest" style="color: red;"></p>
            		    <input type="hidden" name="daily" id="DailyInterestt">
            		</div>
            	</div>
            	<div class="form-group" style="float: right;">
            		<button type="submit" class="btn btn-success">Confirm Plan</button>
            	</div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
<script type="text/javascript">
        $("#UserAmount").keyup(function(){
		  	var amount = $(this).val();
		  	var plan   = $("#UserPlan").val();
		  	var url    = $("#GetPercentageUrl").val();
		  	$.ajaxSetup({
	  	        headers: {
	  	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  	        }
	  	    });
		  	$.ajax({
		  		url:url,
		  		type:'post',
		  		data: {plan:plan , amount:amount},
                success:function(data){
                	$("#percentageForResult").val(data.net_profit);
                	$("#DailyInterestt").val(data.daily);
                	$("#DailyInterest").text('Your Daily Interest is '+data.daily);
                	$("#CapitalAmount").val(data.capital);
                },
		  	});

		});
		$("#UserPlan").on('change',function(){
		  	var plan   = $("#UserAmount").val('');
		  	$("#percentageForResult").val('');
		});
    </script>
@endpush


