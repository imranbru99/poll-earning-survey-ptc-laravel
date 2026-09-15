@extends('admin.layouts.app')
@section('panel')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">

            <div class="container-fluid">
                <div class="card">
                    <!-- /.card-header -->
                   <div class="table-responsive">
                       <div class="card-body">
                           <table id="example" class="table  table-bordered table-striped table--light">
                               <thead>
                               <tr>
                                   <th>Sr#</th>
                                   <th>username</th>
                                   <th>title</th>
                                   <th>Amount</th>
                                   <th>Time</th>
                                   <!-- <th>Review</th> -->
                                   <th>Status</th>
                                   <th>Action</th>
                               </tr>
                               </thead>
                               <tbody>
                               @forelse($result as $key => $val)
{{--                                   {{dd($val)}}--}}
                                   @if($val->deleted_at == null)
                                       <tr>
                                           <td style="width: 5%;">{{ ($key+1) }}</td>
                                           <td style="width: 10%;">{{ $val->username }}</td>
                                           <td style="width: 10%;">{{ $val->title }}</td>
                                           <td style="width: 10%;">{{ $val->amount }}</td>
                                           <td style="width: 10%;">{{ $val->time }}</td>
                                           <!-- <td style="width: 10%;">{{ $val->comment }}</td> -->
                                           <td style="width: 10%;">
                                               @if($val->is_pending)
                                                   <span class="badge badge-success">Complete</span>
                                               @else
                                                   <span class="badge badge-danger">Pending</span>
                                               @endif
                                           </td>
                                           <td style="width: 15%;">
                                               <div class="dropdown">
                                                   <button class="btn dropdown-toggle" type="button" id="dropdownMenu2"
                                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                       <i class="menu-icon la la-expand"></i>
                                                   </button>
                                                   <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                       <a class="dropdown-item" data-toggle="modal" data-target="#exampleModalAccept" id="AcceptMicrojobId" data-attr="{{ route('microJobs.show', $val->id) }}"
                                                          href="#"><i
                                                               class="menu-icon fas fa-thumbs-up mr-2"></i> Approval</a>
                                                               
                                                        <a class="dropdown-item"
                                                          href="#" data-toggle="modal" data-target="#exampleModalReject" id="RejectMicrojobId" data-attr="{{ route('microJobs.delete', $val->id) }} ">
                                                            <i class="menu-icon fas fa fa-ban mr-2"></i>
                                                            Reject
                                                        </a>
                                                       <a class="dropdown-item"
                                                          href="#" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" id="ViewImageMicrojob" data-image="{{ $val->comment }}" data-attr="{{ route('microJobs.showImage', $val->id) }}"><i
                                                               class="menu-icon fas fa fa-link mr-2"></i>View Image</a>
                                                   </div>
                                               </div>

                                           </td>
                                       </tr>
                                   @endif
                               @empty
                                   <tr>
                                       <td colspan="8">
                                           Not Record Found.
                                       </td>
                                   </tr>
                               @endforelse
                               </tbody>
                           </table>
                       </div>
                   </div>
                    <!-- /.card-body -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Images</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body scrollbar scrollbar-primary">
                            <h2>Review</h2>
                            <p id="ImageViewReviewModal"></p><br>
                            <div id="ImageViewModal" class="force-overflow" style="height:400px; ">
                                
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal fade" id="exampleModalReject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                            Reject Confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                            <form action="" method="post" id="SubmitRejectMicroJobForm">
                                @csrf
                                <div class="modal-body">
                                    <textarea name="details" class="form-control pt-3" rows="3" placeholder="Provide the Details" required=""></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn--dark" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn--danger">Reject</button>
                                </div>
                            </form>
                        </div>
                      </div>
                    </div>
                    <div class="modal fade" id="exampleModalAccept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                            Accept Confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                            <form action="" method="get" id="SubmitAcceptMicroJobForm">
                                @csrf
                                <div class="modal-body">
                                    <textarea name="details" class="form-control pt-3" rows="3" placeholder="Provide the Details" required=""></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn--dark" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn--danger">Accept</button>
                                </div>
                            </form>
                        </div>
                      </div>
                    </div>
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
    <script type="text/javascript">
        $(document).on('click','#ViewImageMicrojob',function(e) {
            e.preventDefault();
            let href = $(this).attr('data-attr');
            let review = $(this).attr('data-image');
            $('#ImageViewReviewModal').text(review);
            $.ajax({
               url:href,
               method:'get',
              success: function(data) {
                if (data.status == true) {
                    $("#ImageViewModal").html(data.output);
                }
              },
            })
        });
    </script>
    <script type="text/javascript">
        $(document).on('click','#RejectMicrojobId',function(e) {
            e.preventDefault();
            let href = $(this).attr('data-attr');
            $('#SubmitRejectMicroJobForm').attr('action',href);
        });
    </script>
    <script type="text/javascript">
        $(document).on('click','#AcceptMicrojobId',function(e) {
            e.preventDefault();
            let href = $(this).attr('data-attr');
            $('#SubmitAcceptMicroJobForm').attr('action',href);
        });
    </script>
@endpush
