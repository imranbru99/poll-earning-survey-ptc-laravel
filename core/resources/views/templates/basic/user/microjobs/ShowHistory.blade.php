@extends($activeTemplate . 'layouts.user')
@section('content')
    @include($activeTemplate . 'breadcrumb')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <table id="example" class="table  table-bordered table-striped table--light">
                    <thead class="bg-warning p-1">
                        <tr>
                            <th>Sr</th>
                            <th>Title</th>
                            <th>Completed Time</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($result as $key => $val)
                            <tr>
                                <td style="width: 10%;">{{ $loop->iteration }}</td>
                                <td style="width: 10%;">{{ $val->title }}</td>
                                <td style="width: 10%;"> {{ showDateTime($val->created_at) }}</td>
                                <td style="width: 10%;">
                                    @if ($val->is_pending == 1 && $val->deleted_at == null)
                                        <span class="badge badge-success">Completed</span>
                                        <button class="btn btn-sm btn-info infoBtn" data-toggle="modal"
                                            data-target="#exampleModalAdminFeed"
                                            data-info="{{ $val->admin_feedback }}">@lang('Review')</button>
                                    @elseif($val->is_pending == 0 && $val->deleted_at != null)
                                        <span class="badge badge-danger">Rejected</span>
                                        <button class="btn btn-sm btn-info infoBtn" data-toggle="modal"
                                            data-target="#exampleModalAdminFeed"
                                            data-info="{{ $val->admin_feedback }}">@lang('Rejected Notice')</button>
                                    @else
                                        <span class="badge badge-primary">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                            <tr>
                                <td class="text-center" colspan="100%">{{ __($empty_message) }}</td>
                            </tr>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="exampleModalAdminFeed" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <strong class="modal-title method-name" id="exampleModalLabel">@lang('MicroJob Details')</strong>
                            <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>
                        <div class="modal-body">
                            <p id="DetailsMicroJobDes"> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
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
    <script type="text/javascript">
        $(document).on('click', '.infoBtn', function() {
            $('#DetailsMicroJobDes').html($(this).data('info'));
        });
    </script>
@endpush
