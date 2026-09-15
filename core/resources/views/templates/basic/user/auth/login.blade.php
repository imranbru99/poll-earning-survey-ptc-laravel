@extends($activeTemplate . 'layouts.auth')
@section('content')
    <div class="auth-shell">
        <div class="auth-side">
            <a class="brand" href="{{ route('home') }}">
                <img src="{{ asset(imagePath()['logoIcon']['path'] . '/logo.png') }}" alt="logo">
            </a>
            <div>
                <div class="kicker">Member access</div>
                <h1>Welcome back to your earning desk.</h1>
                <p class="lead">Surveys, news views, jobs and referrals wait in one dashboard.</p>
            </div>
            <p style="color:var(--muted)">Need an account? <a href="{{ route('user.register') }}" style="color:var(--gold)">Create one</a></p>
        </div>
        <div class="auth-form-wrap">
            <div class="auth-card form-card">
                <h3>Sign in</h3>
                <form action="{{ route('user.login') }}" method="post">
                    @csrf
                    <label>Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required>
                    <label>Password</label>
                    <input type="password" name="password" id="loginPassword" required>
                    <div style="display:flex;justify-content:space-between;margin:14px 0">
                        <label style="display:flex;gap:8px;align-items:center">
                            <input type="checkbox" onclick="var p=document.getElementById('loginPassword');p.type=p.type==='password'?'text':'password'"> Show
                        </label>
                        <a href="{{ route('user.password.request') }}" style="color:var(--gold)">Forgot password?</a>
                    </div>
                    <button class="btn-gold" type="submit" style="width:100%">Login now</button>
                </form>
            </div>
        </div>
    </div>
@endsection
