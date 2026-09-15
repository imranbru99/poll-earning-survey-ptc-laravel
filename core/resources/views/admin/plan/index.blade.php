@extends('admin.layouts.app')
@section('panel')
	<div class="form-group" style="float: right;">
		<a href="{{ route('admin.add_user_plan') }}" class="btn btn-primary btn-sm"> Add New </a>
	</div><br><br>
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
                                    <th>Sr#</th>
                                    <th>title</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                	@foreach($userPlans as $key => $plan)
                                	<tr>
                                		<td>{{++$key}}</td>
                                		<td>{{$plan->title}}</td>
                                		<td>{{$plan->value}}</td>
                                		<td>
                                			<a href="{{route('admin.edit_user_plan',$plan->id)}}"><span class="badge badge-success">Edit</span></a>
                                			<a href="{{route('admin.delete_user_plan',$plan->id)}}"><span class="badge badge-danger">Delete</span></a>
                                		</td>
                                	</tr>
                                	@endforeach
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


