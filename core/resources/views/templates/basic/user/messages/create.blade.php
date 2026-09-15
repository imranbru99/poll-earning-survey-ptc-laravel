@extends($activeTemplate . 'layouts.user')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <h4>Create a new Conversation</h4>
            <form action="{{ route('user.messages.store') }}" method="post">
                {{ csrf_field() }}
                <div class="col">
                    <!-- Subject Form Input -->
                    <div class="form-group">
                        <label class="control-label">Subject</label>
                        <input type="text" class="form-control" name="subject" placeholder="Subject"
                            value="{{ old('subject') }}">
                    </div>
                    <!-- Message Form Input -->
                    <div class="form-group">
                        <label class="control-label">Message</label>
                        <textarea name="message" class="form-control" id="exampleTextarea1">{{ old('message') }}</textarea>
                    </div>



                    @if (count($users) > 0)
                        <div class="checkbox">
                            @foreach ($users as $user)
                                <label title="{{ $user->fullname }}">
                                    <input type="checkbox" name="recipients[]"
                                        value="{{ $user->id }}">{{ $user->fullname }}
                                </label>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary form-control">Submit</button>
                        </div>
                    @else
                        <label colspan="100%" class="text-center"> @lang('You have no refer User, Please refer user first to send message! Then You can create conversation')!</label>
                    @endif

                </div>
            </form>
        </div>
    </div>
@endsection
