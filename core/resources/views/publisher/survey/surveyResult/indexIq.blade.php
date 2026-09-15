@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
    <div class="container">
        <div class="card">
            <div class="row bg-secondary">
                <div class="col-md-2">Question</div>
                <div class="col-md-10">{{ $question }}</div>
                <br>
            </div>
        </div>
        <div class="card">
            <div class="row p-3">
                @foreach($answers as $answer)
                    <div class="col-md-2">Answer {{ $loop->index+1 }}:</div>
                    @php
                        $data = explode(',',$answer->option)
                    @endphp
                    @foreach ($data as $record)
                        @if($record != "")
                            @php
                                $a = App\Models\Survey\QuestionOption::find($record);
                            @endphp
                            <div class="col-md-2">{{ $a->option }}</div>
                        @endif
                    @endforeach
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
@endsection
