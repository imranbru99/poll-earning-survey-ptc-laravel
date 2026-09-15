<div class="sidebar capsule--rounded bg_img overlay--dark"
     data-background="{{asset('assets/admin/images/sidebar/2.jpg')}}">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{route('admin.dashboard')}}" class="sidebar__main-logo"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="image"></a>
            <a href="{{route('admin.dashboard')}}" class="sidebar__logo-shape"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}" alt="image"></a>
            <button type="button" class="navbar__expand"></button>
        </div>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item {{menuActive('admin.dashboard')}}">
                    <a href="{{route('admin.dashboard')}}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('Dashboard')</span>
                    </a>
                </li>
               <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.report*',3)}}">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title">@lang('Report') </span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.report*',2)}} ">
                        <ul>
                        <li class="sidebar-menu-item {{menuActive('admin.Status')}}">
                            <a href="{{route('admin.Status')}}" class="nav-link ">
                                <i class="menu-icon las la-user"></i>
                                <span class="menu-title">@lang('Active User')</span>
                            </a>
                        </li>
                         <li class="sidebar-menu-item {{menuActive(['admin.report.invest'])}}">
                                <a href="{{route('admin.report.invest')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Invest Log')</span>
                                </a>
                            </li>
                             <li class="sidebar-menu-item {{menuActive(['admin.report.refCom'])}}">
                                <a href="{{route('admin.report.refCom')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Referral Commission')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive(['admin.report.transaction','admin.report.transaction.search'])}}">
                                <a href="{{route('admin.report.transaction')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Transaction Log')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive(['admin.report.ptcview*'])}}">
                                <a href="{{route('admin.report.ptcview')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('PTC View Log')</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                             <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.deposit*',3)}}">
                        <i class="menu-icon las la-credit-card"></i>
                        <span class="menu-title">@lang('Deposit System')</span>
                        @if(0 < $pending_deposits_count)
                            <span class="menu-badge pill bg--primary ml-auto" >
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.deposit*',2)}} ">
                        <ul>

                            <li class="sidebar-menu-item {{menuActive('admin.deposit.gateway.index')}} ">
                                <a href="{{route('admin.deposit.gateway.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Automatic Gateways')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.deposit.manual.index')}} ">
                                <a href="{{route('admin.deposit.manual.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Manual Gateways')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.deposit.pending')}} ">
                                <a href="{{route('admin.deposit.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Deposits')</span>
                                    @if($pending_deposits_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$pending_deposits_count}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.deposit.approved')}} ">
                                <a href="{{route('admin.deposit.approved')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Approved Deposits')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.deposit.successful')}} ">
                                <a href="{{route('admin.deposit.successful')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Successful Deposits')</span>
                                </a>
                            </li>


                            <li class="sidebar-menu-item {{menuActive('admin.deposit.rejected')}} ">
                                <a href="{{route('admin.deposit.rejected')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Rejected Deposits')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.deposit.list')}} ">
                                <a href="{{route('admin.deposit.list')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Deposits')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.withdraw*',3)}}">
                        <i class="menu-icon la la-bank"></i>
                        <span class="menu-title">@lang('Withdrawals') </span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.withdraw*',2)}} ">
                        <ul>

                            <li class="sidebar-menu-item {{menuActive('admin.withdraw.method.index')}}">
                                <a href="{{route('admin.withdraw.method.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Withdraw Methods')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.withdraw.pending')}} ">
                                <a href="{{route('admin.withdraw.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Log')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.withdraw.approved')}} ">
                                <a href="{{route('admin.withdraw.approved')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Approved Log')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.withdraw.rejected')}} ">
                                <a href="{{route('admin.withdraw.rejected')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Rejected Log')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.withdraw.log')}} ">
                                <a href="{{route('admin.withdraw.log')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Withdrawals Log')</span>
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>
      

               <li class="sidebar-menu-item ">
                    <a href="makeme" class="nav-link">
                        <i class="menu-icon las la-broom"></i>
                        <span class="menu-title">Clear Cache</span>
                    </a>
                </li>


                 {{-- Survey Link HERE --}}

              <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.survey*',3)}}">
                        <i class="menu-icon las la-dot-circle"></i>
                        <span class="menu-title">@lang('Survey Tasks')</span></a>
                    <div class="sidebar-submenu {{menuActive('admin.survey*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.survey.create')}} ">
                                <a href="{{ route('admin.survey.create') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Add New Surveys')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.survey.all-surveys')}} ">
                                <a href="{{ route('admin.survey.all-surveys') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Surveys')</span>
                                    @if($Survey_count)
                                       <span class="menu-badge pill bg--primary ml-auto">{{ $Survey_count }}</span>
                                     @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item  ">
                                <a href="{{ route('questionImport.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Completed Survey')</span>
                                       @if($ComplatedSurvey_count)
                                       <span class="menu-badge pill bg--primary ml-auto">{{ $ComplatedSurvey_count }}</span>
                                     @endif
                                </a>
                            </li>
                               <li class="sidebar-menu-item {{menuActive('admin.survey.export-survey')}} ">
                                <a href="{{ route('admin.survey.export-survey') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Export Survey')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- END of Survey Link HERE --}}

                {{-- Microjob section Start --}}
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('microJobs*',3)}}">
                        <i class="menu-icon fal fa-award"></i>
                        <span class="menu-title">@lang('Microjob Task')</span>
                        @if($submitting_count)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('microJobs*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('microJobs.edit')}}">
                                <a href="{{route('microJobs.edit',0)}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Add New Microjob')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ str_contains(Route::current()->getName(), "microJobs.index") ? 'active' : '' }} ">
                                <a href="{{route('microJobs.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Microjob List')</span>
                                    @if($microjob_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{ $microjob_count }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ str_contains(Route::current()->getName(), "microJobs.submitting") ? 'active' : '' }} ">
                                <a href="{{ route('microJobs.submitting') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Submiting Job')</span>
                                    @if($submitting_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{ $submitting_count }}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ str_contains(Route::current()->getName(), "microJobs.submitted") ? 'active' : '' }} ">
                                <a href="{{ route('microJobs.submitted') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Submitted Job')</span>
                                    @if($submitted_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{ $submitted_count }}</span>
                                    @endif
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                {{-- Microjob sction closeing  --}}
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.post*',3)}}">
                        <i class="menu-icon la la-blog"></i>
                        <span class="menu-title">@lang('Topics') </span>
                            @if($pending_post)
                                <span class="menu-badge pill bg--primary ml-auto">
                                    <i class="fa fa-exclamation"></i>
                                </span>
                             @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.post*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive(['admin.post.pending'])}}">
                                <a href="{{route('admin.post.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Topics')</span>
                                    @if($pending_post)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$pending_post}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive(['admin.post.approved'])}}">
                                <a href="{{route('admin.post.approved')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Approved Topics')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.post.all')}}">
                                <a href="{{route('admin.post.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Topics')</span>
                                </a>
                            </li>
                          <li class="sidebar-menu-item {{menuActive(['admin.post.comment'])}}">
                                <a href="{{route('admin.post.comment')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('comment Topics')</span>
                                    @if($pending_Comment)
                                    <span class="menu-badge pill bg--primary ml-auto">{{$pending_Comment}}</span>
                                @endif
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

       
<!--Publisher Start-->

   <li class="sidebar-menu-item {{menuActive('admin.publisher.users')}} ">
                <a href="{{route('admin.messages')}}" class="nav-link">
                    <i class="menu-icon las la-dot-circle"></i>
                    <span class="menu-title">@lang('Message')</span>

                </a>
            </li>
<!--Publisher Close -->

            

                <li class="sidebar-menu-item {{ menuActive('admin.ptc*') }}">
                    <a href="{{ route('admin.ptc.index') }}" class="nav-link">
                        <i class="las la-link menu-icon"></i>
                        <span class="menu-title">@lang('PTC Ads')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.users*',3)}}">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title">@lang('Manage Users')</span>

                        <!--@if($banned_users_count > 0 || $email_unverified_users_count > 0 || $sms_unverified_users_count > 0)-->
                        <!--    <span class="menu-badge pill bg--primary ml-auto">-->
                        <!--        <i class="fa fa-exclamation"></i>-->
                        <!--    </span>-->
                        <!--@endif-->
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.users*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.users.all')}} ">
                                <a href="{{route('admin.users.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Users')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.users.active')}} ">
                                <a href="{{route('admin.users.active')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Active Users')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.users.banned')}} ">
                                <a href="{{route('admin.users.banned')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Banned Users')</span>
                                    @if($banned_users_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$banned_users_count}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item  {{menuActive('admin.users.emailUnverified')}}">
                                <a href="{{route('admin.users.emailUnverified')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email Unverified')</span>

                                    @if($email_unverified_users_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$email_unverified_users_count}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.users.smsUnverified')}}">
                                <a href="{{route('admin.users.smsUnverified')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('SMS Unverified')</span>
                                    @if($sms_unverified_users_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$sms_unverified_users_count}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.users.login.history')}}">
                                <a href="{{route('admin.users.login.history')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Login History')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.users.email.all')}}">
                                <a href="{{route('admin.users.email.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Send Email')</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

 

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.ticket*',3)}}">
                        <i class="menu-icon la la-ticket"></i>
                        <span class="menu-title">@lang('Support Ticket') </span>
                        @if(0 < $pending_ticket_count)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.ticket*',2)}} ">
                        <ul>

                            <li class="sidebar-menu-item {{menuActive('admin.ticket')}} ">
                                <a href="{{route('admin.ticket')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Ticket')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.ticket.pending')}} ">
                                <a href="{{route('admin.ticket.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Ticket')</span>
                                    @if($pending_ticket_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$pending_ticket_count}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.ticket.closed')}} ">
                                <a href="{{route('admin.ticket.closed')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Closed Ticket')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.ticket.answered')}} ">
                                <a href="{{route('admin.ticket.answered')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Answered Ticket')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

    <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.publish.user*',3)}}">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title">@lang('Advertiser Users')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.publish.user*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.publisher.users')}} ">
                                <a href="{{route('admin.publisher.users')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Users')</span>
                                      @if($PublisherUser_count)
                                    <span class="menu-badge pill bg--primary ml-auto">{{ $PublisherUser_count }}</span>
                                @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.publish.user.all-surveys')}} ">
                                <a href="{{ route('admin.publish.user.all-surveys') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Surveys')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.publish.user.microjob')}} ">
                                <a href="{{route('admin.publish.user.microjob')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Microjob List')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('admin.publish.user.ptc.index') }}">
                                <a href="{{ route('admin.publish.user.ptc.index') }}" class="nav-link">
                                    <i class="las la-link menu-icon"></i>
                                    <span class="menu-title">@lang('PTC Ads')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--Publisher Close -->

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.report*',3)}}">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title">@lang('Report') </span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.report*',2)}} ">
                        <ul>

                             <li class="sidebar-menu-item {{menuActive(['admin.report.invest'])}}">
                                <a href="{{route('admin.report.invest')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Invest Log')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive(['admin.report.transaction','admin.report.transaction.search'])}}">
                                <a href="{{route('admin.report.transaction')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Transaction Log')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive(['admin.report.ptcview*'])}}">
                                <a href="{{route('admin.report.ptcview')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('PTC View Log')</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li class="sidebar-menu-item  {{menuActive(['admin.language-manage','admin.language-key'])}}">
                    <a href="{{route('admin.language-manage')}}" class="nav-link"
                       data-default-url="{{ route('admin.language-manage') }}">
                        <i class="menu-icon las la-language"></i>
                        <span class="menu-title">@lang('Language') </span>
                    </a>
                </li>

                <li class="sidebar__menu-header">@lang('Settings')</li>

                <li class="sidebar-menu-item {{ menuActive('admin.referrals') }}">
                    <a href="{{ route('admin.referrals') }}" class="nav-link">
                        <i class="las la-tree menu-icon"></i>
                        <span class="menu-title">@lang('Ref Commission') </span>
                    </a>
                </li>

                    <li class="sidebar-menu-item {{ menuActive('admin.plan*') }}">
                    <a href="{{ route('admin.plan.index') }}" class="nav-link">
                        <i class="las la-tags menu-icon"></i>
                        <span class="menu-title">@lang('Membership Plan')</span>
                    </a>
                </li>

                 <li class="sidebar-menu-item {{ menuActive('#*') }}">
                    <a href="#" class="nav-link" id="clearAds">
                        <i class="fas fa-snowplow mr-3"></i>
                        <span class="menu-title">@lang('Clear ads showed')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{menuActive('admin.setting.index')}}">
                    <a href="{{route('admin.setting.index')}}" class="nav-link">
                        <i class="menu-icon las la-life-ring"></i>
                        <span class="menu-title">@lang('Settings')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{menuActive('admin.setting.logo-icon')}}">
                    <a href="{{route('admin.setting.logo-icon')}}" class="nav-link">
                        <i class="menu-icon las la-images"></i>
                        <span class="menu-title">@lang('Logo Icon Setting')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{menuActive('admin.plugin.index')}}">
                    <a href="{{route('admin.plugin.index')}}" class="nav-link">
                        <i class="menu-icon las la-cogs"></i>
                        <span class="menu-title">@lang('Plugins')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{menuActive('admin.seo')}}">
                    <a href="{{route('admin.seo')}}" class="nav-link">
                        <i class="menu-icon las la-globe"></i>
                        <span class="menu-title">@lang('SEO')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.email-template*',3)}}">
                        <i class="menu-icon la la-envelope-o"></i>
                        <span class="menu-title">@lang('Email Manager')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.email-template*',2)}} ">
                        <ul>

                            <li class="sidebar-menu-item {{menuActive('admin.email-template.global')}} ">
                                <a href="{{route('admin.email-template.global')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Global Template')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive(['admin.email-template.index','admin.email-template.edit'])}} ">
                                <a href="{{ route('admin.email-template.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email Templates')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.email-template.setting')}} ">
                                <a href="{{route('admin.email-template.setting')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email Configure')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

         <li class="sidebar-menu-item {{menuActive('admin.forum')}}">
                    <a href="{{route('admin.forum')}}" class="nav-link ">
                        <i class="menu-icon las la-layer-group"></i>
                        <span class="menu-title">@lang('Forum')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{menuActive('admin.category')}}">
                    <a href="{{route('admin.category')}}" class="nav-link ">
                        <i class="menu-icon las la-scroll"></i>
                        <span class="menu-title">@lang('Category')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{menuActive('admin.sub.category')}}">
                    <a href="{{route('admin.sub.category')}}" class="nav-link ">
                        <i class="menu-icon las la-scroll"></i>
                        <span class="menu-title">@lang('Sub Category')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.sms-template*',3)}}">
                        <i class="menu-icon la la-mobile"></i>
                        <span class="menu-title">@lang('SMS Manager')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.sms-template*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.sms-template.global')}} ">
                                <a href="{{route('admin.sms-template.global')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('API Setting')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive(['admin.sms-template.index','admin.sms-template.edit'])}} ">
                                <a href="{{ route('admin.sms-template.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('SMS Templates')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

       

                <li class="sidebar__menu-header">@lang('PAGE BUILDER')</li>

                <li class="sidebar-menu-item {{menuActive('admin.frontend.manage.pages')}}">
                    <a href="{{route('admin.frontend.manage.pages')}}" class="nav-link ">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title">@lang('Manage Pages')</span>
                    </a>
                </li>
        <li class="sidebar-menu-item {{ menuActive('admin.user_plans') }}">
                    <a href="{{ route('admin.user_plans') }}" class="nav-link">
                        <i class="las la-tree menu-icon"></i>
                        <span class="menu-title">@lang('User Plans') </span>
                    </a>
                </li>
                <li class="sidebar__menu-header">@lang('CONTENT MANAGER')</li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.frontend.sections*',3)}}">
                        <i class="menu-icon la la-html5"></i>
                        <span class="menu-title">@lang('Section Manage')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.frontend.sections*',2)}} ">
                        <ul>
                            @php
                               $lastSegment =  collect(request()->segments())->last();
                               $pageSections = getPageSections(1);
                               ksort($pageSections);
                            @endphp

                            @foreach($pageSections as $k => $secs)
                                @if($secs['builder'])
                                    <li class="sidebar-menu-item  @if($lastSegment == $k) active @endif ">
                                        <a href="{{ route('admin.frontend.sections',$k) }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">{{$secs['name']}}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach


                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- sidebar end -->
