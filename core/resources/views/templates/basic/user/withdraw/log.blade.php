
@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<section>
   <div class="container-fluid">
       <div class="row">
           <div class="col-md-12">
                   <div class="table-responsive--sm">
                       <table class="table table-striped">
                           <thead class="thead-dark">
                           <tr>
                               <th scope="col">@lang('Transaction ID')</th>
                               <th scope="col">@lang('Payment Method')</th>
                               <th scope="col">@lang('Amount')</th>
                               <th scope="col">@lang('Status')</th>
                               <th scope="col">@lang('Time')</th>
                           </tr>
                           </thead>
                           <tbody>
                    
                               @forelse($withdraws as $k=>$data)
                                   <tr>
                                       <td data-label="@lang('Transaction Id')">{{$data->trx}}</td>
                                       <td data-label="@lang('Gateway')">{{ $data->method->name   }}</td>
                                       <td data-label="@lang('Amount')">
                                           <strong>{{getAmount($data->amount)}} {{$general->cur_text}}</strong>
                                       </td>
                                       <td data-label="@lang('Status')">
                                           @if($data->status == 2)
                                               <span class="badge badge-warning">@lang('You will get This Payment in The Last Week of This Month')</span>
                                           @elseif($data->status == 1)
                                               <span class="badge badge-success">@lang('Completed')</span>
                                               <button class="btn btn-sm btn-info infoBtn" data-info="{{ $data->admin_feedback }}">@lang('TxnID')</button>
                                           @elseif($data->status == 3)
                                               <span class="badge badge-danger">@lang('Rejected')</span>
                                               <button class="btn btn-sm btn-info infoBtn" data-info="{{ $data->admin_feedback }}">@lang('Rejected Notice')</button>
                                           @endif

                                       </td>
                                       <td data-label="@lang('Time')">
                                           <i class="fa fa-calendar"></i> {{date('d M, Y ', strtotime($data->created_at))}}
                                           <span class="pl-1"></span> {{date('h:i A', strtotime($data->created_at))}}
                                       </td>
                                   </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                            </tr>
                            @endforelse
                           </tbody>
                       </table>
                   </div>
   

               {{$withdraws->links($activeTemplate.'paginate')}}
           </div>
       </div>
   </div>
</section>


<!-- Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title method-name" id="exampleModalLabel">@lang('Withdrawl Transaction ID')</strong>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                  <p></p>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
<script type="text/javascript">
  (function ($) {
     "use strict";
      $('.infoBtn').click(function(){
        var modal = $('#infoModal');
        modal.find('p').html($(this).data('info'));
        modal.modal('show');
      });
  })(jQuery);
</script>
@endpush
