@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<div class="row mt-5 mb-5">
    <div class="col-lg-12">
        <div style="float: right; margin-right: 55px; margin-bottom: 20px;">
<a href="{{route('publisher_user.ptc.create')}}" class="btn float-right cmn-btn mb-4" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Add New Ptc">
<i class="fa fa-plus"></i> Add New Ptc </a>
        </div><br>
        <div class="container card">
            <div class="table-responsive--sm">
                <table class="table table--light style--two">
                    <thead>
                        <tr>
                            <th scope="col">@lang('Title')</th>
                            <th scope="col">@lang('Type')</th>
                            <th scope="col">@lang('Duration')</th>
                            <th scope="col">@lang('Maximum View')</th>
                            <th scope="col">@lang('Viewed')</th>
                            <th scope="col">@lang('Remain')</th>
                            <th scope="col">@lang('Amount')</th>
                            <th scope="col">@lang('Status')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ptcs as $ptc)
                        <tr>
                            <td data-label="@lang('Title')">{{description_shortener($ptc->title,20)}}</td>
                            <td data-label="@lang('Type')">
                                    @if($ptc->ads_type == 1)
                                        <span class="font-weight-normal text--small badge badge--success"><i class="fa fa-link"></i> @lang('URL')</span>
                                    @elseif($ptc->ads_type == 2)
                                        <span class="font-weight-normal text--small badge badge--dark"><i class="fa fa-image"></i> @lang('Image')</span>
                                    @else
                                        <span class="font-weight-normal text--small badge badge--primary"><i class="fa fa-code"></i> @lang('Script')</span>
                                    @endif
                            </td>
                            <td data-label="@lang('Duration')">{{$ptc->duration}} @lang('Sec')</td>
                            <td data-label="@lang('Maximum View')">{{$ptc->max_show}}</td>
                            <td data-label="@lang('Viewed')">{{$ptc->showed}}</td>
                            <td data-label="@lang('Remain')">{{$ptc->remain}}</td>


                            <td data-label="@lang('Amount')" class="font-weight-bold">{{ $ptc->amount+0 }} {{$general->cur_text}}</td>     

                            <td data-label="@lang('Status')">
                                @if($ptc->status == 1)
                                    <span class="font-weight-normal text--small badge badge-success">@lang('active')</span>
                                @else
                                    <span class="font-weight-normal text--small badge badge-danger">@lang('inactive')</span>
                                @endif
                            </td>
                            <td data-label="@lang('Action')"><a class="icon-btn" href="{{route('publisher_user.ptc.edit',$ptc->id)}}"><i class="la la-pen"></i></a></td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer py-4">
                <nav aria-label="...">
                    {{ $ptcs->links('admin.partials.paginate') }}
                </nav>
            </div>
        </div>
    </div>
</div>


@endsection


