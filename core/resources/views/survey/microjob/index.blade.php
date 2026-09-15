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
                                    <th>Amount</th>
                                    <th>Job Limit</th>
                                     <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($jobs as $key => $val)
                                    <tr>
                                        <td style="width: 10%">{{ ($key+1) }}</td>
                                        <td style="width: 10%">{{ $val->title }}</td>
                                        <td style="width: 10%">{{ $val->amount }}</td>
                                      
                                        <td style="width: 10%">{{ $val->limit }}</td>
                                        <td style="width: 10%">
                                            @if ($val->status == 1)
                                                <a href="{{ route('admin.publish.user.microjob.status', $val->id) }}"> <span
                                                        class="badge badge-primary">active</span></a>
                                            @else
                                                <a href="{{ route('admin.publish.user.microjob.status', $val->id) }}"> <span
                                                        class="badge badge-danger">Deactivate</span></a>
                                            @endif
                                        </td>

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
                                                    <a class="dropdown-item" id="openModal" data-id="{{ $val->id }}">
                                                    <i class="far fa-eye">
                                                         </i>Previews Task
                                                  </a>      
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
     <!-- Modal -->
<div class="modal fade" id="staticBackdrop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Task Description and Step</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                     <ul class="list-group list-group-flush" id="fillRespondeData">
                                    <li class="list-group-item">An item</li>
                           
                      </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>       
            
        </section>
    </div>
@endsection
  <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>

 <script>
        $(document).on('click', '#openModal', function(e){
            e.preventDefault();
            var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'), {
                // keyboard: false
            });
            var id= $(this).attr('data-id');
            // alert(id);
            $.get("/modal-get-info/"+id,
                function (response) {
                    $("#fillRespondeData").text('');
                        $("#fillRespondeData").append('<li class="list-group-item">'+ response.info.description+'</li>');
                        $("#fillRespondeData").append('<li class="list-group-item">'+ response.info.set_of_jobs+'</li>');
                        myModal.show();
                },
            );
        });
        $(document).off('click', '#staticclose', function(){
            var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'), {
                // keyboard: false
            });
            myModal.hide();
 })(jQuery);
    </script>
    
        <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
@endpush
