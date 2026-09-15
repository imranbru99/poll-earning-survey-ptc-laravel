@extends($activeTemplate . 'layouts.user')
@section('content')
    @include($activeTemplate . 'breadcrumb')
    <div class="container-fluid">
        <div class="card-body">
            <table id="example" class="table  table-bordered table-striped table--light">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">@lang('Title')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                </thead>
                <tbody class="list">
                    @forelse($ads as $data)
                        @if (!in_array($data->id, $viewed))
                            <tr>
                                <td data-label="@lang('Title')">{{ __($data->title) }}</td>
                                <td data-label="@lang('Action')">
                                    <a href="{{ route('user.ptc.show', Crypt::encryptString($data->id . '|' . auth()->user()->id)) }}"
                                        class="btn btn-primary" target="_blank">@lang('View Now')</a>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td class="text-center" colspan="100%">{{ __($empty_message) }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $ads->links($activeTemplate . 'paginate') }}
    </div>
    </section>
@endsection
