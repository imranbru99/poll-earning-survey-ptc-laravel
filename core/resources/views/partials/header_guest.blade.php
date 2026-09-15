


 <!-- ======= Header ======= -->
 <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ route('user.home') }}" class="logo d-flex align-items-center">
        <img src="{{ asset(imagePath()['logoIcon']['path'] .'/favicon.png') }}" alt="">
        <span class="d-none d-lg-block">{{ $general->sitename }}</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
     <p><span class="small"> Your level {{ Auth::user()->l0 }}</span></p>
    </div><!-- End Logo -->
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
          </a>
        </li><!-- End Search Icon-->
        <li class="nav-item dropdown">

            <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
              <i class="bi bi-bell"></i>
              <span class="badge bg-primary badge-number">
                @if($userNotifications->count() > 0)
                {{ $userNotifications->count() }}
                @else
                0
                @endif

              </span>
            </a><!-- End Notification Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
              <li class="dropdown-header">
               <p> You have
               @if($userNotifications->count() > 0)
               {{ $userNotifications->count() }}
               @else
               0
               @endif
                 new notifications</p>
                <a href="{{ route('user.notifications') }}"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>

              <li class="notification-item">
                <i class="bi bi-exclamation-circle"></i>
                <div>
                    @foreach($userNotifications as $notification)
                  <h4><h6 class="notifi__title">{{ __($notification->title) }}</h6></h4>
                  <p>{{ $notification->created_at->diffForHumans() }}</p>
                  @endforeach
                </div>
              </li>

              <li>
                <hr class="dropdown-divider">
              </li>
              <li class="dropdown-footer">
                <a href="{{ route('user.notifications') }}">Show all notifications</a>
              </li>

            </ul><!-- End Notification Dropdown Items -->

          </li><!-- End Notification Nav -->



        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">
                @if($thread->count() > 0)
                {{ $thread->count() }}
                @else
                0
                @endif
            </span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
                @if($thread->count() > 0)
                You have {{ $thread->count() }} new messages
                @else
                No message found
                @endif

              <a href="{{ route('user.messages') }}"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>

            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.@$notification->user->image,imagePath()['profile']['user']['size'])}}" alt="">
            <span class="d-none d-md-block dropdown-toggle ps-2"> {{ Auth::user()->fullname }}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6> {{ Auth::user()->fullname }}</h6>
              <span>{{ Auth::user()->designation }}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('user.profile') }}">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('user.twofactor') }}">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('ticket') }}">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('user.logout') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->







  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('user.home') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-side" data-bs-toggle="collapse" href="#">
          <i class="las la-question-circle"></i><span>Poll</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-side" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('user.survey') }}">
              <i class="las la-question-circle"></i><span>Poll</span>
            </a>
          </li>
          <li>
            <a href="{{ route('user.survey.history') }}">
              <i class="las la-history"></i><span>Poll History</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-tep" data-bs-toggle="collapse" href="#">
            <i class="la la-fist-raised"></i><span>Web View</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-tep" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('user.ptc.index') }}">
              <i class="las la-fist-raised"></i><span>Web View</span>
            </a>
          </li>
          <li>
            <a href="{{ route('user.ptc.clicks') }}">
              <i class="las la-history"></i><span>Web View History</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-job" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Network Marketing</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-job" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('user.microJobs.index')}}">
              <i class="las la-paper-plane"></i><span>Start Marketing</span>
            </a>
          </li>
          <li>
            <a href="{{route('user.jobHistory.index')}}">
              <i class="las la-thumbs-up"></i><span>Marketing History</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-plan" data-bs-toggle="collapse" href="#">
          <i class="lab la-squarespace"></i><span>Plan</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-plan" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('user.plans') }}">
              <i class="las la-paper-plane"></i><span>Plan for Daily Earning</span>
            </a>
          </li>
          <li>
            <a href="{{ route('user.calculator') }}">
              <i class="las la-thumbs-up"></i><span>Mining Plan</span>
            </a>
          </li>
          <li>
            <a href="{{ route('user.pl.history') }}">
              <i class="las la-thumbs-up"></i><span>Mining Plan History</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link " data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Deposit</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse active" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('user.deposit')  }}" >
              <i class="bi bi-circle"></i><span>Deposit </span>
            </a>
          </li>
          <li>
            <a href="{{ route('user.deposit.history') }}">
              <i class="bi bi-circle"></i><span>Deposit History</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('user.transactions') }}">
          <i class="bi bi-layout-text-window-reverse"></i><span>Transaction</span>
        </a>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed"  href="{{ route('user.referred') }}">
          <i class="las la-poll"></i><span>Refer</span>
        </a>
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Withdraw</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('user.bonus') }}">
              <i class="bi bi-circle"></i><span>Withdraw Bonus Account</span>
            </a>
          </li>
          <li>
            <a href="{{ route('user.withdraw') }}">
              <i class="bi bi-circle"></i><span>Withdraw Basic Account</span>
            </a>
          </li>
          <li>
            <a href="{{ route('user.withdraw.history') }}">
              <i class="bi bi-circle"></i><span>Withdraw History</span>
            </a>
          </li>
        </ul>
      </li><!-- End Icons Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="lab la-blogger"></i><span>Forum Post</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('post.all') }}">
              <i class="las la-inbox"></i><span>Community</span>
            </a>
          </li>
          <li>
            <a href="{{ route('user.post.all') }}">
              <i class="las la-inbox"></i><span>All post</span>
            </a>
          </li>
          <li>
            <a href="{{ route('user.post.form') }}">
              <i class="bi bi-circle"></i><span>Create a new Post</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-mess" data-bs-toggle="collapse" href="#">
          <i class="lab la-facebook-messenger"></i><span>Message</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-mess" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('user.messages') }}">
              <i class="las la-inbox"></i><span>Message</span>
            </a>
          </li>
          <li>
            <a href="{{ route('user.messages.create') }}">
              <i class="bi bi-circle"></i><span>Create a new Message</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->


      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('user.profile') }}">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('user.guide') }}">
          <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('ticket') }}">
          <i class="bi bi-envelope"></i>
          <span>Support </span>
        </a>
      </li><!-- End Contact Page Nav -->
 <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('user.change.password') }}">
          <i class="fa fa-key"></i>
          <span>Change password </span>
        </a>
      </li><!-- End Contact Page Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="https://trfou.com/Trade_Fou.apk">
          <i class="fab fa-app-store"></i>
          <span>Download Mobile App </span>
        </a>
      </li><!-- End Contact Page Nav -->
 <li class="nav-item">
        <a class="nav-link collapsed">
          
        </a>
      </li><!-- End Contact Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->
