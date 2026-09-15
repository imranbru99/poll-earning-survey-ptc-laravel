@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<section class="cmn-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card table-card">
                    <div class="card-body p-o">
                        <div class="table-responsive--sm">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">@lang('Serial')</th>
                                        <th scope="col">@lang('Plan name')</th>
                                        <th scope="col">@lang('Total Invest')</th>
                                        <th scope="col">@lang('Total Profit')</th>
                                        <th scope="col">@lang('Daily Interest ')</th>
                                        <th scope="col">@lang('Status')</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @forelse($pl as $survey)
                                    <tr>
                                        <td data-label="">{{ $loop->iteration }}</td>
                                        <td data-label="">{{ $survey->plan }}  </td>
                                        <td data-label="">{{ $survey->amount }} USD</td>
                                        <td data-label="">{{ $survey->profit }} USD</td>
                                        <td data-label="">{{ $survey->daily_interest }} USD</td>
                                        <td data-label="">{{showDateTime($survey->created_at,'d M, Y h:i A')}}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">You did not choose a plan yet</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
