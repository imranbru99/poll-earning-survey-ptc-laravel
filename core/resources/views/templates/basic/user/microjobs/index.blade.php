@extends($activeTemplate . 'layouts.user')
@section('content')
    <div class="container-fluid">
        <table id="example" class="table  table-bordered table-striped table--light">
            <thead class="bg-success p-1">
                <tr>
                    <th>Sr</th>
                    <th>MicroJob Title</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            @forelse($jobs as $key => $val)
                @if ($val->comment == null)
                    <tr>
                        <td style="width: 1%;">{{ $loop->iteration }}</td>
                        <td style="width: 10%;">{{ $val->title }}</td>
                        <td style="width: 10%;">{{ $val->amount }} USD</td>
                        <td style="width: 10%;">
                            @if ($val->microjob_id == null)
                                <a class="btn btn-primary"
                                    href="{{ route('user.microJobs.edit', Crypt::encryptString($val->id)) }}"
                                    style="color:white">Start
                                </a>
                            @else
                                {{--                                <i>not null</i> --}}
                                @if ($val->comment == null)
                                    <a class="btn btn-primary" href="{{ route('user.microJobs.show', $val->id) }}"
                                        style="color:white">Review
                                    </a>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endif
            @empty
                <tr>
                <tr>
                    <td class="text-center" colspan="100%">{{ __($empty_message) }}</td>
                </tr>
            @endforelse
        </table>

    </div>
@endsection
