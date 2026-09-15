@extends('admin.layouts.app')

    <style>
        * {
            box-sizing: border-box;
        }
        .zoom {
            padding: 20px;
            transition: transform .2s;
            margin: 0 auto;
        }
        .zoom:hover {
            -ms-transform: scale(1.5); /* IE 9 */
            -webkit-transform: scale(1.5); /* Safari 3-8 */
            transform: scale(1.5);
            margin-left: 20px;
            margin-right: 20px;
        }

    </style>

@section('panel')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">

            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-right">
                            <a class="btn-info btn addQuestion" href="{{ route('microJobs.submitting') }}">Back To
                                <i class="fa fa-backward" aria-hidden="true"></i>
                            </a>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                           @forelse($images as $key => $img)
                                <div class="col-12 col-md-6  col-sm-12 col-lg-4">
                                    <div style="width:300px ; height: 300px; ">
                                        <div class="zoom">
                                            <img src="{{ asset('uploads/userjobs/'.$img->image) }}"  alt="Image here">
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-4 col-md-4 col-lg-4 mt-4">
                                    <div style="width:300px ; height: 300px; ">
                                        No Image
                                    </div>
                                </div>
                            @endforelse
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
