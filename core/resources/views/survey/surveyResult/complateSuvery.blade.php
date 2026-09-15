@extends('admin.layouts.app')
@section('panel')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-striped table--light">
                                    <thead>
                                            <tr>
                                                <th>Sr#</th>
                                                <th>User id</th>
                                                <th>User Name</th>
                                                <th>Survey Title</th>
                                                <th>Survey Amount</th>
                                                <th>Date</th>
                                                <th>Status</th>
            
                                            </tr>
                                     </thead>
                                      <tbody>
                                            @forelse($ab as $key => $val)
                                                <tr>
                                                    <td style="width: 5%">{{ ($key+1) }}</td>
                                                     <td style="width: 10%">{{ $val->id }}</td>
                                                     <td data-label="@lang('Username')"><a href="{{ route('admin.users.detail', $val->id) }}">{{ $val->username }}</a></td>
                                                    <td style="width: 10%">{{ $val->name }}</td>
                                                    <td style="width: 10%">{{ $val->amount }}</td>
                                                    <td style="width: 10%">{{ $val->created_at }}</td>
                                                    <td style="width: 10%">
                                                           @if($val->status == 1)
                                                            <span class="badge badge-success">Completed</span>
                                                        @else
                                                            <span class="badge badge-primary">Attempted</span>
                                                        @endif
                                                        </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10">
                                                        Not Record Found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                    </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </section>
    </div>
@endsection
@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@endpush
