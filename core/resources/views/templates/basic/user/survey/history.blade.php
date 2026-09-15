@extends($activeTemplate . 'layouts.user')
@section('content')
    @include($activeTemplate . 'breadcrumb')
    <section>
        <div class="container-fluid">
            <div class="card-body p-o">
                <div class="table-responsive--sm">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Sr</th>
                                <th scope="col">Name</th>
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('Status')</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse($surveys as $survey)
                                <tr>
                                    <td data-label="">{{ $loop->iteration }}
                                    </td>
                                    <td data-label="">
                                        {{ optional(App\Models\Survey\Survey::find($survey->survey_id))->name }}
                                    </td>
                                    <td data-label="">{{ $survey->created_at }}
                                    </td>
                                    <td data-label="">
                                        @if ($survey->status == 1)
                                            <span class="badge badge-success">Completed</span>
                                        @else
                                            <span class="badge badge-primary">Attempted</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">No Opinion Completed Yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
@endpush
