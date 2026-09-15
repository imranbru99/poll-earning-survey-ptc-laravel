@extends('admin.layouts.app')
@section('panel')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-striped table--light">
                                <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Job Title</th>
                                    <th>Category Name</th>
{{--                                    <th>Description</th>--}}
                                    <th>Amount</th>
{{--                                    <th>Set of jobs</th>--}}
                                    <th>Job Limit</th>
                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($jobs as $key => $val)
                                    <tr>
                                        <td style="width: 10%">{{ ($key+1) }}</td>
                                        <td style="width: 10%">{{ $val->title }}</td>
                                        <td style="width: 10%">{{ $val->category->name }}</td>
{{--                                        <td style="width: 10%">{{ $val->description }}</td>--}}
                                        <td style="width: 10%">{{ $val->amount }}</td>
{{--                                        <td style="width: 10%">{{ $val->set_of_jobs }}</td>--}}
                                        <td style="width: 10%">{{ $val->limit }}</td>
                                        <td style="width: 10%">{{ $val->time }}</td>
                                        <td style="width: 15%;">
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button" id="dropdownMenu2"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="menu-icon la la-expand"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                    <a class="dropdown-item"
                                                       href="{{ route('microJobs.edit', $val->id) }}"><i
                                                            class="menu-icon fas fa-pencil-alt mr-2"></i>Edit</a>
                                                    <a class="dropdown-item"
                                                       href="{{  route('microJobs.jobDelete', [$val->id]) }}"><i
                                                            class="menu-icon fas fa-trash mr-2"></i>Delete</a>
                                                </div>
                                            </div>

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
