<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="{{ route('user.home') }}"><img
                    src="{{ asset(imagePath()['logoIcon']['path'] . '/logo.png') }}" alt="logo" /></a>
            <a class="navbar-brand brand-logo-mini" href="{{ route('user.home') }}"><img
                    src="{{ asset(imagePath()['logoIcon']['path'] . '/favicon.png') }}" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="mdi mdi-menu"></span>
            </button>
            <div class="search-field d-none d-md-block">
                <form class="d-flex align-items-center h-100" action="#">
                    <div class="input-group">
                        <div class="input-group-prepend bg-transparent">
                            <i class="input-group-text border-0 mdi mdi-magnify"></i>
                        </div>
                        <input type="text" class="form-control bg-transparent border-0" placeholder="Search">
                    </div>
                </form>
            </div>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <div class="nav-profile-img">
                            <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . @$notification->user->image, imagePath()['profile']['user']['size']) }}"
                                alt="image">
                            <span class="availability-status online"></span>
                        </div>
                        <div class="nav-profile-text">
                            <p class="mb-1 text-black">{{ Auth::user()->fullname }}</p>
                        </div>
                    </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="{{ route('user.transactions') }}">
                            <i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('user.profile') }}">
                            <i class="mdi mdi-account me-2 text-info"></i> My profile </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('user.logout') }}">
                            <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
                    </div>
                </li>
                <li class="nav-item d-none d-lg-block full-screen-link">
                    <a class="nav-link">
                        <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-email-outline"></i>
                        <span class="count-symbol bg-warning"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                        aria-labelledby="messageDropdown">
                        <h6 class="p-3 mb-0">Messages</h6>
                        <div class="dropdown-divider"></div>
                        @if ($thread->count() > 0)
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">

                                </div>
                                <a href="{{ route('user.messages') }}"><span
                                        class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                            </a>
                        @else
                        @endif
                        <div class="dropdown-divider"></div>

                        <div class="dropdown-divider"></div>
                        <h6 class="p-3 mb-0 text-center">
                            @if ($thread->count() > 0)
                                You have {{ $thread->count() }} new messages
                            @else
                                No message found
                            @endif
                        </h6>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                        data-bs-toggle="dropdown">
                        <i class="mdi mdi-bell-outline"></i>
                        <span class="badge bg-primary badge-number">
                            @if ($userNotifications->count() > 0)
                                {{ $userNotifications->count() }}
                            @else
                                0
                            @endif

                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                        aria-labelledby="notificationDropdown">
                        <h6 class="p-3 mb-0">Notifications</h6>
                        <div class="dropdown-divider"></div>
                        @if ($userNotifications->count() > 0)
                            @foreach ($userNotifications as $notification)
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-success">
                                            <i class="mdi mdi-calendar"></i>
                                        </div>
                                    </div>
                                    <div
                                        class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                        <h6 class="preview-subject font-weight-normal mb-1">
                                            {{ __($notification->title) }}</h6>
                                        <p class="text-gray ellipsis mb-0">
                                            {{ $notification->created_at->diffForHumans() }} </p>
                                    </div>
                                </a>
                            @endforeach
                        @else
                        @endif
                        <div class="dropdown-divider"></div>

                        <a href="{{ route('user.notifications') }}">Show all notifications</a>
                    </div>
                </li>
                <li class="nav-item nav-logout d-none d-lg-block">
                    <a class="nav-link" href="{{ route('user.logout') }}">
                        <i class="mdi mdi-power"></i>
                    </a>
                </li>
                <li class="nav-item nav-settings d-none d-lg-block">
                    <a class="nav-link" href="">
                        <i class="mdi mdi-format-line-spacing"></i>
                    </a>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item nav-profile">
                    <a href="#" class="nav-link">
                        <div class="nav-profile-image">
                            <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . @$notification->user->image, imagePath()['profile']['user']['size']) }}"
                                alt="profile">
                            <span class="login-status online"></span>
                            <!--change to offline or busy as needed-->
                        </div>
                        <div class="nav-profile-text d-flex flex-column">
                            <span class="font-weight-bold mb-2">{{ Auth::user()->fullname }}</span>
                            <span class="text-secondary text-small">{{ Auth::user()->designation }}</span>
                        </div>
                        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.home') }}">
                        <span class="menu-title">Dashboard</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <form method="post" action="{{ route('user.checkin') }}">
                        @csrf
                        <button class="nav-link" type="submit" style="background:none;border:0;width:100%;text-align:left">
                            <span class="menu-title">Daily check-in</span>
                            <i class="mdi mdi-calendar-check menu-icon"></i>
                        </button>
                    </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('leaderboard') }}">
                        <span class="menu-title">Leaderboard</span>
                        <i class="mdi mdi-trophy menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                        aria-controls="ui-basic">
                        <span class="menu-title">Opinion</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ route('user.survey') }}">Provide
                                    Opinion</a></li>
                            <li class="nav-item"> <a class="nav-link"
                                    href="{{ route('user.opinion.history') }}">Opinion History</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#u-basic" aria-expanded="false"
                        aria-controls="u-basic">
                        <span class="menu-title">News View</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-eye menu-icon"></i>
                    </a>
                    <div class="collapse" id="u-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ route('user.ptc.index') }}">News
                                    View</a></li>
                            <li class="nav-item"> <a class="nav-link"
                                    href="{{ route('user.ptc.clicks') }}">History</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#du-basic" aria-expanded="false"
                        aria-controls="du-basic">
                        <span class="menu-title">Micro jobs</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-accusoft menu-icon"></i>
                    </a>
                    <div class="collapse" id="du-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link"
                                    href="{{ route('user.microJobs.index') }}">Start Jobs</a></li>
                            <li class="nav-item"> <a class="nav-link"
                                    href="{{ route('user.jobHistory.index') }}">Job History</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#p-basic" aria-expanded="false"
                        aria-controls="p-basic">
                        <span class="menu-title">Deposit</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi  mdi-cash-usd menu-icon"></i>
                    </a>
                    <div class="collapse" id="p-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ route('user.deposit') }}">Deposit</a>
                            </li>
                            <li class="nav-item"> <a class="nav-link"
                                    href="{{ route('user.deposit.history') }}">Deposit History</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.referred') }}">
                        <span class="menu-title">Refer</span>
                        <i class="mdi mdi-contacts menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.plans') }}">
                        <span class="menu-title">Plan</span>
                        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#plan-basic" aria-expanded="false"
                        aria-controls="plan-basic">
                        <span class="menu-title">Plan</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-accusoft menu-icon"></i>
                    </a>
                    <div class="collapse" id="plan-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ route('user.plans') }}">
                                    <span class="menu-title">Plan for Quick Earning</span> </a></li>

                            <li class="nav-item"> <a href="{{ route('user.calculator') }}">
                                    <span class="menu-title">Mining Plan</span>
                                </a></li>
                            <li class="nav-item"> <a href="{{ route('user.pl.history') }}">
                                    <span class="menu-title">Mining Plan History</span>
                                </a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#w-basic" aria-expanded="false"
                        aria-controls="w-basic">
                        <span class="menu-title">Withdraw</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-accusoft menu-icon"></i>
                    </a>
                    <div class="collapse" id="w-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ route('user.bonus') }}">Withdraw
                                    Bonus Balance</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ route('user.withdraw') }}">Withdraw
                                    Main Balance</a></li>
                            <li class="nav-item"> <a class="nav-link"
                                    href="{{ route('user.withdraw.history') }}">Withdraw History</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.transactions') }}">
                        <span class="menu-title">Transaction</span>
                        <i class="mdi mdi-chart-bar menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" aria-expanded="false"
                        aria-controls="general-pages">
                        <span class="menu-title">Message</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-message menu-icon"></i>
                    </a>
                    <div class="collapse" id="general-pages">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ route('user.messages.create') }}">
                                    Create a Conversation </a></li>

                            <li class="nav-item"> <a class="nav-link" href="{{ route('user.messages') }}"> Message
                                </a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#post" aria-expanded="false"
                        aria-controls="post">
                        <span class="menu-title">Post</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-message menu-icon"></i>
                    </a>
                    <div class="collapse" id="post">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ route('post.all') }}">
                                    All Post </a></li>

                            <li class="nav-item"> <a class="nav-link" href="{{ route('user.post.all') }}">
                                    Your All Post
                                </a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ route('user.post.form') }}">
                                    Create a New Post
                                </a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item sidebar-actions">
                    <span class="nav-link">
                        <div class="border-bottom">
                            <h6 class="font-weight-normal mb-3">Personal Info </h6>
                        </div>
                <li class="nav-item"> <a class="nav-link" href="{{ route('user.profile') }}">
                        Profile
                    </a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('user.change.password') }}">
                        Change Password
                    </a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('ticket') }}">
                        Ticket
                    </a></li>
                <a href="#" class="btn btn-block btn-lg btn-gradient-primary mt-4"> Download App</a>
                </span>
                </li>
            </ul>
        </nav>
