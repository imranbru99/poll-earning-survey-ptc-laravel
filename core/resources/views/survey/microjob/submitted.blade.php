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
                                   <th>Sr#</th>
                                     <th>Done Time</th>
                                   <th>username</th>
                                   <th>title</th>
                                   <th>Amount</th>
                                   <th>Status</th>
                               </tr>
                               </thead>
                               <tbody>
                               @forelse($result as $key => $val)
                                   @if($val->is_pending == 0 && $val->deleted_at !=null)
                                       <tr>
                                           <td style="width: 5%;">{{ ($key+1) }}</td>
                                            <td style="width: 10%;"> {{ showDateTime($val->created_at) }}</td>
                                            <td data-label="@lang('Username')"><a href="{{ route('admin.users.detail', $val->id) }}">{{ $val->username }}</a></td>
                                           <td style="width: 10%;">{{ $val->title }}</td>
                                           <td style="width: 10%;">{{ $val->amount }}</td>
                                           <td style="width: 10%;">
                                               @if($val->is_pending == 0 && $val->deleted_at !=null)

                                                   <span class="badge badge-danger">Rejected</span>
                                               @else

                                                   <span class="badge badge-success">Completed</span>

                                           </td>
                                       </tr>
                                       @endif
                                   @elseif($val->is_pending != 0 && $val->deleted_at ==null)
                                       <tr>
                                           <td style="width: 5%;">{{ ($key+1) }}</td>
                                            <td style="width: 10%;"> {{ showDateTime($val->created_at) }}</td>
                                           <td style="width: 10%;"><a href="{{ route('admin.users.detail', $val->id) }}">{{ $val->username }}</a></td>
                                           <td style="width: 10%;">{{ $val->title }}</td>
                                           <td style="width: 10%;">{{ $val->amount }}</td>
                                           <td style="width: 10%;">
                                               @if($val->is_pending == 0 && $val->deleted_at !=null)

                                                   <span class="badge badge-danger">Rejected</span>
                                               @else

                                                   <span class="badge badge-success">Completed</span>
                                               @endif
                                           </td>
                                       </tr>
                                   @endif
                               @empty
                                   <tr>
                                       <td colspan="6">
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
