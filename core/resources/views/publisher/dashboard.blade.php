
@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<section>

        <div class="row cmn-text">
            <div class="col-md-6 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
              <i class="fas fa-dollar-sign overlay-icon text--primary"></i>
              <div class="widget-two__icon b-radius--5 bg--primary">
                <i class="fas fa-dollar-sign"></i>
              </div>
              <div class="widget-two__content">
                <h2 class="bal">{{ $user->balance + 0 }} {{ $general->cur_text }}</h2>
                <p>@lang('My Balance')</p>
              </div>
            </div><!-- widget-two end -->
          </div>
            <div class="col-md-6 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
              <i class="fas fa-tags overlay-icon text--primary"></i>
              <div class="widget-two__icon b-radius--5 bg--primary">
                <i class="far fa-credit-card"></i>
              </div>
              <div class="widget-two__content">
                <h2 class="">{{ isset($user->deposits) ? $user->deposits->sum('amount') : 0 + 0 }} {{ isset($general->cur_text) ? $general->cur_text : '' }}</h2>
                <p>@lang('Total Deposit') <a href="{{ route('publisher_user.deposit.history') }}" class="btn cmn-btn mt-2">@lang('Deposit History ')<i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- widget-two end -->
          </div>
               <div class="col-md-6 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
              <i class="fas fa-poll overlay-icon text--primary"></i>
              <div class="widget-two__icon b-radius--5 bg--primary">
                <i class="fas fa-poll"></i>
              </div>
              <div class="widget-two__content">
                <h2 class="">{{$totalSurvey}}</h2>
                <p>@lang('Total Survey') <a href="{{ route('publisher_user.all-surveys') }}" class="btn cmn-btn mt-2">@lang('View All')<i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- widget-two end -->
        </div>
              <div class="col-md-6 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
              <i class="fas fa-laptop-house overlay-icon text--primary"></i>
              <div class="widget-two__icon b-radius--5 bg--primary">
                <i class="fas fa-laptop-house"></i>
              </div>
              <div class="widget-two__content">
                <h2 class="">{{$totalMicroJob}}</h2>
                <p>@lang('Total MicroJob') <a href="{{url('publisher_user/microJobs')}}" class="btn cmn-btn mt-2">@lang('View All')<i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- widget-two end -->
    </div>
              <div class="col-md-6 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
              <i class="fas fa-ad overlay-icon text--primary"></i>
              <div class="widget-two__icon b-radius--5 bg--primary">
                <i class="fas fa-ad"></i>
              </div>
              <div class="widget-two__content">
                <h2 class="">{{$totalPtc}}</h2>
                <p>@lang('Total PTC') <a href="{{ route('publisher_user.ptc.index') }}" class="btn cmn-btn mt-2">@lang('View All ')<i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- widget-two end -->
            </div>
    <div class="col-md-6 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
              <i class="fas fa-history overlay-icon text--primary"></i>
              <div class="widget-two__icon b-radius--5 bg--primary">
                <i class="fas fa-history"></i>
              </div>
              <div class="widget-two__content">
                <h2 class="">{{$PublishUserTaskTransection}}</h2>
                <p>@lang('Total Transaction') <a href="{{ route('publisher_user.transactions') }}" class="btn cmn-btn mt-2">@lang('View All')<i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- widget-two end -->
</section>
@endsection
@push('script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
(function ($) {
    "use strict";
    // apex-bar-chart js
    var options = {
      series: [{
      name: 'Clicks',
      data: [
        @foreach($chart['click'] as $key => $click)
            {{ $click }},
        @endforeach
      ]
    }, {
      name: 'Earn Amount',
      data: [
            @foreach($chart['amount'] as $key => $amount)
                {{ $amount }},
            @endforeach
      ]
    }],
      chart: {
      type: 'bar',
      height: 580,
      toolbar: {
        show: false
      }
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '55%',
        endingShape: 'rounded'
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    xaxis: {
      categories: [
      @foreach($chart['amount'] as $key => $amount)
                '{{ $key }}',
            @endforeach
    ],
    },
    fill: {
      opacity: 1
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return val
        }
      }
    }
    };
    var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
    chart.render();
        function createCountDown(elementId, sec) {
            var tms = sec;
            var x = setInterval(function() {
                var distance = tms*1000;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML =days+"d: "+ hours + "h "+ minutes + "m " + seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "{{__('COMPLETE')}}";
                }
                tms--;
            }, 1000);
        }
      createCountDown('counter', {{\Carbon\Carbon::tomorrow()->diffInSeconds()}});
})(jQuery);
</script>
@endpush