<?php

namespace App\Providers;

use App\Models\UserNotification;
use App\Models\GeneralSetting;
use Cmgmyr\Messenger\Models\Message;
use App\Models\Language;
use Cmgmyr\Messenger\Models\Thread;
use App\Models\Page;
use App\Models\Plugin;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Forum;
use App\Models\Post;
use App\Models\Comment;
use App\User;
use Carbon\Carbon;
use App\Referral;
use Cmgmyr\Messenger\Models\Participant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $activeTemplate = activeTemplate();

        $viewShare['general'] = GeneralSetting::first();
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language'] = Language::all();
        $viewShare['pages'] = Page::where('tempname',$activeTemplate)->where('slug','!=','home')->get();
        view()->share($viewShare);





        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'PublisherUser_count' => \App\Models\PublisherUser::where('status',1)->count(),
                'Survey_count' => \App\Models\Survey\Survey::count(),
                'ComplatedSurvey_count' => \App\Models\ComplatedSurvey::where('status',1)->groupBy('survey_id')->count(),
                'submitting_count' => \App\Models\Survey\UserMicroJob::where('is_pending',0)->count(),
                'submitted_count' => \App\Models\Survey\UserMicroJob::where('is_pending',1)->count(),
                'microjob_count' => \App\Models\Survey\MicroJob::count(),
                'pending_post'    => Post::where('status', 2)->count(),
                'pending_Comment'    => Comment::count(),
                'microjob' => \App\Models\Survey\UserMicroJob::where('is_pending',0)->where('created_at',date('Y-m-d'))->count(),
                'email_unverified_users_count' => \App\Models\User::emailUnverified()->count(),
                'banned_users_count'           => \App\Models\User::banned()->count(),
                'sms_unverified_users_count'   => \App\Models\User::smsUnverified()->count(),
                'pending_ticket_count'         => \App\Models\SupportTicket::whereIN('status', [0,2])->count(),
                'pending_deposits_count'    => \App\Models\Deposit::pending()->count(),
                'pending_withdraw_count'    => \App\Models\Withdrawal::pending()->count(),
            ]);
        });


        view()->composer('partials.sidebar', function ($view) {
            $view->with([
                'userNotifications'=> \App\Models\UserNotification::where('read_status',0)->where('user_id', auth()->user()->id)->orderBy('id','desc')->get(),
            ]);
        });

        view()->composer('partials.sidebar', function ($view) {
            $view->with([
                'userMessages'=> Message::where('user_id', auth()->user()->id)->orderBy('id','desc')->get(),
            ]);
        });

        view()->composer('partials.sidebar', function ($view) {
            $view->with([
                'thread'=>Thread::forUser(Auth::id())->latest('updated_at')->get(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = \App\Models\Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

         // Enable pagination
        if (!Collection::hasMacro('paginate')) {

            Collection::macro('paginate',
                function ($perPage = 15, $page = null, $options = []) {
                $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                return (new LengthAwarePaginator(
                    $this->forPage($page, $perPage)->values()->all(), $this->count(), $perPage, $page, $options))
                    ->withPath('');
            });
        }

    }
}
