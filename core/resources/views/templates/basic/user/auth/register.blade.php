@extends($activeTemplate . 'layouts.auth')
@section('content')
    <div class="auth-shell">
        <div class="auth-side">
            <a class="brand" href="{{ route('home') }}">
                <img src="{{ asset(imagePath()['logoIcon']['path'] . '/logo.png') }}" alt="logo">
            </a>
            <div>
                <div class="kicker">Join the network</div>
                <h1>Create your earning profile.</h1>
                <p class="lead">Unlock surveys, news view, micro jobs, daily check-in and referral commissions.</p>
            </div>
            <p style="color:var(--muted)">Already registered? <a href="{{ route('user.login') }}" style="color:var(--gold)">Login</a></p>
        </div>
        <div class="auth-form-wrap">
            <div class="auth-card form-card">
                <h3>Create account</h3>
                <form action="{{ route('user.register') }}" method="post">
                    @csrf
                    @if ($reference)
                        <label>Referred by</label>
                        <input type="text" name="referral" value="{{ $reference }}" readonly>
                    @endif
                    <label>First name</label>
                    <input type="text" name="firstname" value="{{ old('firstname') }}" required>
                    <label>Last name</label>
                    <input type="text" name="lastname" value="{{ old('lastname') }}" required>
                    <label>Country & phone</label>
                    <div class="search-bar">
                        <select name="country_code">@include('partials.country_code')</select>
                        <input type="text" name="mobile" placeholder="Phone" value="{{ old('mobile') }}" required>
                    </div>
                    <input type="hidden" name="country">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    <label>Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required>
                    <label>Password</label>
                    <input type="password" name="password" required>
                    <label>Confirm password</label>
                    <input type="password" name="password_confirmation" required>
                    <button class="btn-gold" type="submit" style="width:100%;margin-top:18px">Sign up</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script>
    var country = document.querySelector('select[name=country_code]');
    var hidden = document.querySelector('input[name=country]');
    function syncCountry() {
        var option = country.options[country.selectedIndex];
        hidden.value = option.getAttribute('data-country') || '';
    }
    if (country && hidden) {
        syncCountry();
        country.addEventListener('change', syncCountry);
    }
</script>
@endpush
