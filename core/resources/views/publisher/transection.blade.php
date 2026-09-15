
@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<section>
    <div class="container mt-4">
        <div class="row mb-6-8">
            <div class="col-md-12 mb-3">
                <div class="card table-card">
                    <div class="card-body p-0">
                        
                        <div class="table-responsive--sm">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">@lang('ID')</th>
                                    <th scope="col">@lang('Usernmae')</th>
                                    <th scope="col">@lang('Task Name')</th>
                                    <th scope="col">@lang('Task Type')</th>
                                    <th scope="col">@lang('Cost')</th>
                                    <th scope="col">@lang('Date')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($logs) >0)
                                    @foreach($logs as $k => $data)
                                        <tr>
                                            <td data-label="@lang('Id')">{{++$k}}</td>
                                            <td data-label="@lang('Usernmae')">
                                                {{$data->username}}
                                            </td>
                                            <td data-label="@lang('Task Name')">
                                            	{{$data->task_name}}
                                            </td>
                                            <td data-label="@lang('Task Type')">{{ $data->task_type }}</td>
                                            <td data-label="@lang('Cost')">{{ $data->cost }}</td>
                                            <td data-label="@lang('Date')">{{date('d M, Y', strtotime($data->created_at))}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="100%" class="text-center"> @lang('No results found')!</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{$logs->links($activeTemplate.'paginate')}}
            </div>
        </div>
    </div>
    </section>
@endsection
