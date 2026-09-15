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
                            <table id="example" class="table  table-bordered table-striped table--light">
                                <thead>
	                                <tr>
	                                    <th>S/N0 # </th>
                                        <th scope="col">name</th>
                                        <th scope="col">@lang('Total Earn')</th>
                                        <th scope="col">@lang('Date')</th>
                                        <th scope="col">@lang('Status')</th>
                                    </tr>
                                </thead>
                                <tbody>
	                                @forelse($surveys as $key => $survey)
	                                    <tr>
	                                        <td style="width: 5%">
                                            {{ $key+1 }}
                                        </td>
	                                        <td data-label="">{{
	                                            optional(App\Models\Survey\Survey::find($survey->survey_id))->name }}
	                                        </td>
	                                        <td data-label="">{{
	                                            optional(App\Models\Survey\Survey::find($survey->survey_id))->amount }} TK
	                                        </td>
	                                         <td data-label="">{{$survey->created_at }}
	                                        </td>
                                            <td data-label="">
                                                @if($survey->status == 1)
                                                    <span class="badge badge-success">Completed</span>
                                                @else
                                                    <span class="badge badge-primary">Attempted</span>
                                                @endif
                                            </td>
	                                    </tr>
	                                @empty
	                                <tr>
	                                    <td class="text-center" colspan="100%">Empty</td>
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


