@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
    <div class="content-wrapper mt-4 mb-4">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="">
                <div class="container card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-striped table--light">
                                <thead>
                                <tr>
                                    <th>S/N0 # </th>
                                    <th>Survey Name</th>
                                    <th>Category</th>
                                    <th>Questions</th>
                                    {{-- <th scope="col">@lang('Trying')</th> --}}
                                    <th>Completed</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                    <th>Date Created</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($surveys as $key => $survey)
                                    <tr>
                                        <td style="width: 5%">
                                            {{ $key+1 }}
                                        </td>
                                        <td style="width: 10%">
                                            {{ $survey->name }}
                                        </td>
                                        <td >
                                            {{ $survey->category->name }}
                                            {{-- /can we use category name here sure use here category name --}}
                                        </td>
                                        <td >
                                            @if ($survey->questions->count() >0)
                                                <span class="badge badge-primary">{{ $survey->questions->count() }}</span>
                                            @else {{ 'None' }}
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $surveysi = App\ComplatedSurvey::where('survey_id',$survey->id)->get();
                                                if(isset($surveysi[0])){
                                                    // dump($surveysi);
                                                $i = 0;
                                                $count = 1;
                                                foreach ($surveysi as $surveyi) {
                                                if (isset($surveysi[$i - 1]))
                                                if ($surveysi[$i - 1]->user_id != $surveyi->user_id)
                                                $count++;
                                                $i++;
                                                }
                                                }
                                            @endphp
                                            @isset($count)
                                                @if($count != 0)
                                                    {{ $count }} People
                                                    @php
                                                        $count = 0;
                                                    @endphp
                                                @else
                                                    0 People
                                                @endif
                                            @else
                                                0 People
                                            @endisset

                                        </td>
                                        <td >
                                            @if ($survey->active == 1)
                                                <a href="#"> <span
                                                        class="badge badge-primary">active</span></a>
                                            @else
                                                <a href="#"> <span
                                                        class="badge badge-danger">Deactivate</span></a>
                                            @endif
                                        </td>
                                        <td >
                                            {{ isset($survey->amount)? $survey->amount : '0' }} TK
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button" id="dropdownMenu2"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="menu-icon la la-expand"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                    <a class="dropdown-item"
                                                       href="{{ route('publisher_user.question.create', [$survey->id])}}"><i
                                                            class="menu-iconla la la-edit mr-2"></i> Add Questions</a>
                                                    <a class="dropdown-item"
                                                       href="{{ route('publisher_user.question.show', [$survey->id])}}"><i
                                                            class="menu-iconla la la-edit mr-2"></i> Show Question</a>
                                                    <a class="dropdown-item"
                                                       href="{{ route('publisher_user.question.update', [$survey->id])}}"><i
                                                            class="menu-iconla la la-edit mr-2"></i> Edit Question</a>
                                                    <!-- <a class="dropdown-item"
                                                       href="{{ route('publisher_user.import', [$survey->id])}}"><i
                                                            class="menu-iconla la la-edit mr-2"></i> Import Survey</a> -->
                                                    <a class="dropdown-item"
                                                       href="{{ route('publisher_user.delete', [$survey->id])}}"><i
                                                            class="menu-icon text-danger la la-trash mr-2"></i> Remove Survey</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ Carbon\Carbon::parse($survey['created_at'])->format('M d Y') }}
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
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </section>
    </div>

    @endsection
    @push('script')
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/dataTables.bootstrap4.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.1/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
        <script>

            $(document).ready(function() {
                $('#example').DataTable();
            } );
        </script>
@endpush
