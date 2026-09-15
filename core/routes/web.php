<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;







// Route::get('make-controller', function () {
//     Artisan::call('make:controller QuestionoptionController');
//     return "Controller Created";
// });

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Route::get('/modal-get-info/{id}', 'Admin\MicrojobController@getInfoForModal')->middleware('admin');


// User Support Ticket
Route::prefix('ticket')->group(function () {
    Route::get('/', 'TicketController@supportTicket')->name('ticket');
    Route::get('/new', 'TicketController@openSupportTicket')->name('ticket.open');
    Route::post('/create', 'TicketController@storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'TicketController@viewTicket')->name('ticket.view');
    Route::put('/reply/{ticket}', 'TicketController@replyTicket')->name('ticket.reply');
    Route::get('/download/{ticket}', 'TicketController@ticketDownload')->name('ticket.download');
});


/*
|--------------------------------------------------------------------------
| Start Admin Area
|--------------------------------------------------------------------------
*/


Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::post('/', 'LoginController@login')->name('login.post');
        Route::get('logout', 'LoginController@logout')->name('logout');

        // Admin Password Reset
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify-code');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.change-link');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
    });


    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');
        Route::post('/clear-ads-showed-for-today', 'ClearShowedConroller@clearShowads')->name('clear-ads-showed');
        Route::get('profile', 'AdminController@profile')->name('profile');
        Route::post('profile', 'AdminController@profileUpdate')->name('profile.update');
        Route::get('password', 'AdminController@password')->name('password');
        Route::post('password', 'AdminController@passwordUpdate')->name('password.update');
      
      
      
Route::get('makeme', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
     Artisan::call('route:clear');
    Artisan::call('config:clear');
     Artisan::call('optimize:clear');
    $notify[] = ['success','Successfully cache Cleared'];
     return redirect()->back()->withNotify($notify);
 });


       // status checking
        Route::get('Status', 'AdminController@Status')->name('Status');

     //publisher User
        Route::get('publisher-users', 'AdminPublishUserController@allUsers')->name('publisher.users');
        Route::get('publisher-user/detail/{id}', 'AdminPublishUserController@detail')->name('publisher.users.detail');
        Route::post('publisher-user/update/{id}', 'AdminPublishUserController@update')->name('publisher.users.update');
        Route::get('publisher-user/deposits/{id}', 'AdminPublishUserController@deposits')->name('publisher.users.deposits');
        Route::get('publisher-user/ptc', 'AdminPublishUserController@PublisherPtc')->name('publish.user.ptc.index');
        Route::get('publisher-user/ptc/status/{id}', 'AdminPublishUserController@PublisherStatusPtc')->name('publish.user.ptc.status');
        Route::get('publisher-user/survey', 'AdminPublishUserController@PublisherSurvey')->name('publish.user.all-surveys');
        Route::get('publisher-user/survey/status/{id}', 'AdminPublishUserController@PublisherSurveyStaus')->name('publish.user.all-surveys.status');
        Route::get('publisher-user/microjob', 'AdminPublishUserController@PublishUserMicroJob')->name('publish.user.microjob');
        Route::get('publisher-user/microjob/status/{id}', 'AdminPublishUserController@PublisherMicrojobStaus')->name('publish.user.microjob.status');


         //Message
         Route::group(['prefix' => '/messages'],  function () {
            Route::get('/', ['as' => 'messages', 'uses' => 'MessageController@index']);
            Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessageController@show']);
        });


        //Forum

        Route::get('category', 'CategoryController@index')->name('category');
        Route::post('add/category', 'CategoryController@add')->name('category.add');
        Route::post('update/category', 'CategoryController@update')->name('category.update');

        Route::get('sub/category', 'CategoryController@subCategory')->name('sub.category');
        Route::post('add/sub/category', 'CategoryController@addSubCategory')->name('add.sub.category');
        Route::post('update/sub/category', 'CategoryController@updateSubCategory')->name('update.sub.category');

        Route::get('forums', 'ForumController@index')->name('forum');
        Route::post('add/forum', 'ForumController@add')->name('forum.add');
        Route::post('update/forum', 'ForumController@update')->name('forum.update');

        Route::get('posts/pending', 'PostController@pending')->name('post.pending');
        Route::get('posts/approved', 'PostController@approved')->name('post.approved');
        Route::get('posts/reject/{id}', 'PostController@reject')->name('post.reject');
        Route::get('posts/comment', 'PostController@indexComment')->name('post.comment');
        Route::get('posts/delete/{id}', 'PostController@delete')->name('post.delete');
        Route::get('posts', 'PostController@posts')->name('post.all');
        Route::post('post/approve', 'PostController@approve')->name('post.approve');
        Route::get('post/details/{id}', 'PostController@details')->name('post.details');

        Route::get('users/posts/{id}', 'ManageUsersController@posts')->name('users.post.all');
        Route::get('users/tickets/{id}', 'ManageUsersController@tickets')->name('users.tickets');

        // Users Manager
        Route::get('users', 'ManageUsersController@allUsers')->name('users.all');
        Route::get('users/active', 'ManageUsersController@activeUsers')->name('users.active');
        Route::get('users/banned', 'ManageUsersController@bannedUsers')->name('users.banned');
        Route::get('users/email-verified', 'ManageUsersController@emailUnverifiedUsers')->name('users.emailVerified');
        Route::get('users/email-unverified', 'ManageUsersController@emailUnverifiedUsers')->name('users.emailUnverified');
        Route::get('users/sms-unverified', 'ManageUsersController@smsUnverifiedUsers')->name('users.smsUnverified');
        Route::get('users/sms-verified', 'ManageUsersController@smsUnverifiedUsers')->name('users.smsVerified');

        Route::get('users/{scope}/search', 'ManageUsersController@search')->name('users.search');
        Route::get('user/detail/{id}', 'ManageUsersController@detail')->name('users.detail');
        Route::get('user/survey/history/{id}', 'ManageUsersController@SurveyHistory')->name('users.survey_history');
        Route::post('user/update/{id}', 'ManageUsersController@update')->name('users.update');
        Route::post('user/add-sub-balance/{id}', 'ManageUsersController@addSubBalance')->name('users.addSubBalance');
        Route::get('user/send-email/{id}', 'ManageUsersController@showEmailSingleForm')->name('users.email.single');
        Route::post('user/send-email/{id}', 'ManageUsersController@sendEmailSingle')->name('user.email.single');
        Route::get('user/login/{id}', 'ManageUsersController@login')->name('users.login');
        Route::get('user/transactions/{id}', 'ManageUsersController@transactions')->name('users.transactions');
        Route::get('user/deposits/{id}', 'ManageUsersController@deposits')->name('users.deposits');
        Route::get('user/withdrawals/{id}', 'ManageUsersController@withdrawals')->name('users.withdrawals');
        Route::get('user/total-referral/{id}', 'ManageUsersController@totalReferral')->name('users.totalReferral');
        Route::get('user/commissions/{id}', 'ManageUsersController@commissions')->name('users.commissions');
        // Login History
        Route::get('users/login/history/{id}', 'ManageUsersController@userLoginHistory')->name('users.login.history.single');
        Route::get('users/login/history', 'ManageUsersController@loginHistory')->name('users.login.history');
        Route::get('users/login/ipHistory/{ip}', 'ManageUsersController@loginIpHistory')->name('users.login.ipHistory');

        Route::get('users/send-email', 'ManageUsersController@showEmailAllForm')->name('users.email.all');
        Route::post('users/send-email', 'ManageUsersController@sendEmailAll')->name('users.email.send');


        // Subscriber
        Route::get('subscriber', 'SubscriberController@index')->name('subscriber.index');
        Route::get('subscriber/send-email', 'SubscriberController@sendEmailForm')->name('subscriber.sendEmail');
        Route::post('subscriber/remove', 'SubscriberController@remove')->name('subscriber.remove');
        Route::post('subscriber/send-email', 'SubscriberController@sendEmail')->name('subscribers.sendEmail');

        // DEPOSIT SYSTEM
        Route::get('deposit', 'DepositController@deposit')->name('deposit.list');
        Route::get('deposit/pending', 'DepositController@pending')->name('deposit.pending');
        Route::get('deposit/rejected', 'DepositController@rejected')->name('deposit.rejected');
        Route::get('deposit/approved', 'DepositController@approved')->name('deposit.approved');
        Route::get('deposit/successful', 'DepositController@successful')->name('deposit.successful');
        Route::get('deposit/details/{id}', 'DepositController@details')->name('deposit.details');

        Route::post('deposit/reject', 'DepositController@reject')->name('deposit.reject');
        Route::post('deposit/approve', 'DepositController@approve')->name('deposit.approve');
        Route::get('deposit/{scope}/search', 'DepositController@search')->name('deposit.search');

        // Deposit Gateway
        Route::get('deposit/gateway', 'GatewayController@index')->name('deposit.gateway.index');
        Route::get('deposit/gateway/edit/{alias}', 'GatewayController@edit')->name('deposit.gateway.edit');
        Route::post('deposit/gateway/update/{code}', 'GatewayController@update')->name('deposit.gateway.update');
        Route::post('deposit/gateway/remove/{code}', 'GatewayController@remove')->name('deposit.gateway.remove');
        Route::post('deposit/gateway/activate', 'GatewayController@activate')->name('deposit.gateway.activate');
        Route::post('deposit/gateway/deactivate', 'GatewayController@deactivate')->name('deposit.gateway.deactivate');

        // Manual Methods
        Route::get('deposit/gateway/manual', 'ManualGatewayController@index')->name('deposit.manual.index');
        Route::get('deposit/gateway/manual/new', 'ManualGatewayController@create')->name('deposit.manual.create');
        Route::post('deposit/gateway/manual/new', 'ManualGatewayController@store')->name('deposit.manual.store');
        Route::get('deposit/gateway/manual/edit/{alias}', 'ManualGatewayController@edit')->name('deposit.manual.edit');
        Route::post('deposit/gateway/manual/update/{id}', 'ManualGatewayController@update')->name('deposit.manual.update');
        Route::post('deposit/gateway/manual/activate', 'ManualGatewayController@activate')->name('deposit.manual.activate');
        Route::post('deposit/gateway/manual/deactivate', 'ManualGatewayController@deactivate')->name('deposit.manual.deactivate');

        // Report
        Route::get('report/transaction', 'ReportController@transaction')->name('report.transaction');
        Route::get('report/transaction/search', 'ReportController@transactionSearch')->name('report.transaction.search');
        Route::get('report/invest', 'ReportController@invest')->name('report.invest');
        Route::get('report/referral-commission', 'ReportController@refCom')->name('report.refCom');



        // WITHDRAW SYSTEM
        Route::get('withdraw/pending', 'WithdrawalController@pending')->name('withdraw.pending');
        Route::get('withdraw/approved', 'WithdrawalController@approved')->name('withdraw.approved');
        Route::get('withdraw/rejected', 'WithdrawalController@rejected')->name('withdraw.rejected');
        Route::get('withdraw/log', 'WithdrawalController@log')->name('withdraw.log');
        Route::get('withdraw/{scope}/search', 'WithdrawalController@search')->name('withdraw.search');
        Route::get('withdraw/details/{id}', 'WithdrawalController@details')->name('withdraw.details');
        Route::post('withdraw/approve', 'WithdrawalController@approve')->name('withdraw.approve');
        Route::post('withdraw/reject', 'WithdrawalController@reject')->name('withdraw.reject');


        // Withdraw Method
        Route::get('withdraw/method/', 'WithdrawMethodController@methods')->name('withdraw.method.index');
        Route::get('withdraw/method/create', 'WithdrawMethodController@create')->name('withdraw.method.create');
        Route::post('withdraw/method/create', 'WithdrawMethodController@store')->name('withdraw.method.store');
        Route::get('withdraw/method/edit/{id}', 'WithdrawMethodController@edit')->name('withdraw.method.edit');
        Route::post('withdraw/method/edit/{id}', 'WithdrawMethodController@update')->name('withdraw.method.update');
        Route::post('withdraw/method/activate', 'WithdrawMethodController@activate')->name('withdraw.method.activate');
        Route::post('withdraw/method/deactivate', 'WithdrawMethodController@deactivate')->name('withdraw.method.deactivate');


        // Admin Support
        Route::get('tickets', 'SupportTicketController@tickets')->name('ticket');
        Route::get('tickets/pending', 'SupportTicketController@pendingTicket')->name('ticket.pending');
        Route::get('tickets/closed', 'SupportTicketController@closedTicket')->name('ticket.closed');
        Route::get('tickets/answered', 'SupportTicketController@answeredTicket')->name('ticket.answered');
        Route::get('tickets/view/{id}', 'SupportTicketController@ticketReply')->name('ticket.view');
        Route::put('ticket/reply/{id}', 'SupportTicketController@ticketReplySend')->name('ticket.reply');
        Route::get('ticket/download/{ticket}', 'SupportTicketController@ticketDownload')->name('ticket.download');
        Route::post('ticket/delete', 'SupportTicketController@ticketDelete')->name('ticket.delete');


        // Language Manager
        Route::get('/language', 'LanguageController@langManage')->name('language-manage');
        Route::post('/language', 'LanguageController@langStore')->name('language-manage-store');
        Route::delete('/language/delete/{id}', 'LanguageController@langDel')->name('language-manage-del');
        Route::post('/language/update/{id}', 'LanguageController@langUpdatepp')->name('language-manage-update');
        Route::get('/language/edit/{id}', 'LanguageController@langEdit')->name('language-key');
        Route::put('/language/keyword-update/{id}', 'LanguageController@langUpdate')->name('language.key-update');
        Route::post('/language/import', 'LanguageController@langImport')->name('language.import_lang');



        Route::post('store-lang-key/{id}', 'LanguageController@storeLanguageJson')->name('store-lang-key');
        Route::post('delete-lang-key/{id}', 'LanguageController@deleteLanguageJson')->name('delete-lang-key');
        Route::post('update-lang-key/{id}', 'LanguageController@updateLanguageJson')->name('update-lang-key');



        // General Setting
        Route::get('setting', 'GeneralSettingController@index')->name('setting.index');
        Route::post('setting', 'GeneralSettingController@update')->name('setting.update');

        // Logo-Icon
        Route::get('setting/logo-icon', 'GeneralSettingController@logoIcon')->name('setting.logo-icon');
        Route::post('setting/logo-icon', 'GeneralSettingController@logoIconUpdate')->name('settings.logo-icon');

        // Plugin
        Route::get('plugin', 'PluginController@index')->name('plugin.index');
        Route::post('plugin/update/{id}', 'PluginController@update')->name('plugin.update');
        Route::post('plugin/activate', 'PluginController@activate')->name('plugin.activate');
        Route::post('plugin/deactivate', 'PluginController@deactivate')->name('plugin.deactivate');


        // Email Setting
        Route::get('email-template/global', 'EmailTemplateController@emailTemplate')->name('email-template.global');
        Route::post('email-template/global', 'EmailTemplateController@emailTemplateUpdate')->name('emails-template.global');
        Route::get('email-template/setting', 'EmailTemplateController@emailSetting')->name('email-template.setting');
        Route::post('email-template/setting', 'EmailTemplateController@emailSettingUpdate')->name('emails-template.setting');
        Route::get('email-template/index', 'EmailTemplateController@index')->name('email-template.index');
        Route::get('email-template/{id}/edit', 'EmailTemplateController@edit')->name('email-template.edit');
        Route::post('email-template/{id}/update', 'EmailTemplateController@update')->name('email-template.update');
        Route::post('email-template/send-test-mail', 'EmailTemplateController@sendTestMail')->name('email-template.sendTestMail');


        // SMS Setting
        Route::get('sms-template/global', 'SmsTemplateController@smsSetting')->name('sms-templates.global');
        Route::post('sms-template/global', 'SmsTemplateController@smsSettingUpdate')->name('sms-template.global');
        Route::get('sms-template/index', 'SmsTemplateController@index')->name('sms-template.index');
        Route::get('sms-template/edit/{id}', 'SmsTemplateController@edit')->name('sms-template.edit');
        Route::post('sms-template/update/{id}', 'SmsTemplateController@update')->name('sms-template.update');
        Route::post('email-template/send-test-sms', 'SmsTemplateController@sendTestSMS')->name('email-template.sendTestSMS');



        ////////////////////////// PTC

        //refer
        Route::get('/referral', 'AdminController@referrals')->name('referrals');
        Route::post('/referral', 'AdminController@referralsUpdate')->name('referrals.update');
        Route::post('/referral/when', 'AdminController@referralsWhen')->name('referrals.when');


        //Plan
        Route::get('/plan', 'PlanController@index')->name('plan.index');
        Route::post('/plan', 'PlanController@update')->name('plan.update');


        //PTC ADS
        Route::get('/ptc', 'PtcController@index')->name('ptc.index');
        Route::get('/ptc/create', 'PtcController@create')->name('ptc.create');
        Route::post('/ptc/store', 'PtcController@store')->name('ptc.store');
        Route::get('/ptc/edit/{id}', 'PtcController@edit')->name('ptc.edit');
        Route::post('/ptc/update/{id}', 'PtcController@update')->name('ptc.update');
        Route::get('/ptc/delete/{id}', 'PtcController@destroy')->name('ptc.delete');

        //  PTC VIEW REPORT
        Route::get('report/ptcview', 'ReportController@ptcview')->name('report.ptcview');
        Route::get('report/ptcview/search', 'ReportController@ptcviewSearch')->name('report.ptcview.search');

        // SEO
        Route::get('seo', 'FrontendController@seoEdit')->name('seo');

        // Frontend
        Route::name('frontend.')->prefix('frontend')->group(function () {


            Route::get('templates', 'FrontendController@templates')->name('templates');
            Route::post('templates', 'FrontendController@templatesActive')->name('templates.active');



            Route::get('frontend-sections/{key}', 'FrontendController@frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'FrontendController@frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'FrontendController@frontendElement')->name('sections.element');
            Route::post('remove', 'FrontendController@remove')->name('remove');

            // Page Builder
            Route::get('manage-pages', 'PageBuilderController@managePages')->name('manage.pages');
            Route::post('manage-pages', 'PageBuilderController@managePagesSave')->name('manage.pages.save');
            Route::patch('manage-pages', 'PageBuilderController@managePagesUpdate')->name('manage.pages.update');
            Route::delete('manage-pages', 'PageBuilderController@managePagesDelete')->name('manage.pages.delete');
            Route::get('manage-section/{id}', 'PageBuilderController@manageSection')->name('manage.section');
            Route::post('manage-section/{id}', 'PageBuilderController@manageSectionUpdate')->name('manage.section.update');
        });


    });
});












Route::prefix('admin')->middleware('admin')->group(function () {

   // User Plans
    Route::match(['get','post'],'/user_plans','UserPlanController@index')->name('admin.user_plans');
    Route::match(['get','post'],'/add_plan','UserPlanController@addUserPlan')->name('admin.add_user_plan');
    Route::match(['get','post'],'/edit/{id?}','UserPlanController@editUserPlan')->name('admin.edit_user_plan');
    Route::match(['get','post'],'/delete/{id?}','UserPlanController@deleteUserPlan')->name('admin.delete_user_plan');
  
    // Microjob Route
    Route::get('microJobs/submitting', 'Admin\MicrojobController@submitting')->name('microJobs.submitting');
    Route::get('microJobs/submitted', 'Admin\MicrojobController@submitted')->name('microJobs.submitted');
    Route::post('microJobs/delete/{id}', 'Admin\MicrojobController@delete')->name('microJobs.delete');
    Route::get('microJobs/show/{id}', 'Admin\MicrojobController@show')->name('microJobs.show');
    Route::get('microJobs/image/{id}', 'Admin\MicrojobController@showImage')->name('microJobs.Image');
    Route::get('microJobs/jobDelete/{id}', 'Admin\MicrojobController@jobDelete')->name('microJobs.jobDelete');
    Route::get('jobs/job/{id}', 'Admin\ManageUsersController@jobShow')->name('jobs.jobShow');
    Route::get('jobs/rejected/{id}', 'Admin\ManageUsersController@rejected')->name('jobs.rejected');
    Route::resource('microJobs', 'Admin\MicrojobController');
    Route::resource('questionImport', 'Survey\ImportController');

    //Survey Route
    Route::prefix('survey')->name('admin.survey.')->group(function () {
        Route::get('result/pie/{id}', 'Survey\SurveyController@indexResult')->name('pie.result');
        Route::get('result/input/{id}', 'Survey\SurveyController@indexInputResult')->name('input.result');
        Route::get('result/multi/{id}', 'Survey\SurveyController@indexMultiResult')->name('multi.result');
        Route::get('result/yesno/{id}', 'Survey\SurveyController@indexYesno')->name('yesno.result');
        Route::get('result/iqQuestion/{id}', 'Survey\SurveyController@iqQuestion')->name('iqQuestion.result');
        Route::get('setup', 'Survey\SurveyController@create')->name('create');
        Route::get('status/{id}', 'Survey\SurveyController@status')->name('status');
        Route::post('setup', 'Survey\SurveyController@store')->name('store');
        Route::get('/delete/{survey}', 'Survey\SurveyController@destroy')->name('delete');
        Route::patch('/{survey}', 'Survey\SurveyController@update')->name('update');
        Route::get('/{survey}', 'Survey\SurveyController@show')->name('show');
        Route::get('/{survey}', 'Survey\SurveyController@import')->name('import');
        Route::get('/', 'Survey\SurveyController@index')->name('all-surveys');
        Route::get('/export/survey', 'Survey\SurveyController@ExportSurvey')->name('export-survey');
        Route::get('/export/survey/user/{id}', 'Survey\SurveyController@ExportSurveyUser')->name('export-survey-user');
        Route::get('/export/survey/all/user/', 'Survey\SurveyController@ExportSurveyAllUser')->name('export-survey-all-user');
        Route::get('result/dropdown/{id}', 'survey\surveycontroller@indexdropdown')->name('dropdown.result');



        // Questions
        Route::prefix('question')->name('question.')->group(function () {
            Route::get('add-question/{survey}', 'Survey\SurveyQuestionController@create')->name('create');
            Route::post('add-question/{survey}', 'Survey\SurveyQuestionController@store')->name('store');
            Route::patch('/{question}', 'Survey\SurveyQuestionController@update')->name('update');
            Route::delete('/{question}', 'Survey\SurveyQuestionController@destroy')->name('delete');
            Route::get('edit/{question}', 'Survey\SurveyQuestionController@edit')->name('edit');
            Route::get('/{question}', 'Survey\SurveyQuestionController@show')->name('show');
            Route::get('import/{survey}', 'Survey\SurveyQuestionController@importQuestion')->name('importQuestion');
//            Route::get('importSAveQuestion/{survey}', 'Survey\SurveyQuestionController@importSAveQuestion')->name('importSAveQuestion');
            Route::get('/', 'Survey\SurveyQuestionController@index')->name('all-questions');
        });


        // Publish Survey for Users
        Route::resource('publish-survey', 'Survey\PublishSurveyController');


        // Route::get('publish-survey', 'Survey\PublishSurveyController')->name('all-published');
        // Route::post('publish-survey', 'Survey\PublishSurveyController')->name('store');
        // Route::patch('/{publishsurvey}', 'Survey\PublishSurveyController')->name('update');

        Route::resource('survey-result', 'Survey\SurveyResultController');
        Route::resource('i-q-v-question', 'Survey\IQVQuestionController');
        Route::resource('category', 'Survey\CategoryController');
        Route::resource('publish-i-q-v-question', 'Survey\PublishIQVQuestionController');
        Route::resource('i-q-v-result', 'Survey\IQVResultController');
        Route::resource('i-q-v-test', 'Survey\IQVTestController');
    });
});













/*
|--------------------------------------------------------------------------
| Start User Area
|--------------------------------------------------------------------------
*/

Route::name('user.')->group(function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logoutGet')->name('logout');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register')->middleware('regStatus');

    Route::group(['middleware' => ['guest']], function () {
        Route::get('register/{reference}', 'Auth\RegisterController@referralRegister')->name('refer.register');
    });
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/verify-code', 'Auth\ForgotPasswordController@verifyCode')->name('password.verify-code');
});

Route::namespace('User')->prefix('member')->name('user.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('authorization', 'AuthorizationController@authorizeForm')->name('authorization');
        Route::get('resend-verify', 'AuthorizationController@sendVerifyCode')->name('send_verify_code');
        Route::post('verify-email', 'AuthorizationController@emailVerification')->name('verify_email');
        Route::post('verify-sms', 'AuthorizationController@smsVerification')->name('verify_sms');
        Route::post('verify-g2fa', 'AuthorizationController@g2faVerification')->name('go2fa.verify');

        Route::middleware(['checkStatus'])->group(function () {
            Route::get('dashboard', 'UserController@home')->name('home');
            Route::get('profile-setting', 'UserController@profile')->name('profile');
            Route::post('profile-update', 'UserController@submitProfile')->name('profile.update');
            Route::get('change-password', 'UserController@changePassword')->name('change.password');
            Route::post('change-password', 'UserController@submitPassword');

             // Deposit
            Route::get('calculator','CalculatorController@calculator')->name('calculator');
            Route::post('get_percentage','CalculatorController@getPercentage')->name('get_percentage');
            Route::post('confirm-user-plan','CalculatorController@confirmedPlan')->name('confirmed_plan');
            Route::get('mining/history','CalculatorController@history')->name('pl.history');



            //2FA
            Route::get('twofactor', 'UserController@show2faForm')->name('twofactor');
            Route::post('twofactor/enable', 'UserController@create2fa')->name('twofactor.enable');
            Route::post('twofactor/disable', 'UserController@disable2fa')->name('twofactor.disable');


            //Notification
            Route::get('notifications','UserController@notifications')->name('notifications');
            Route::get('notification/read/{id}','UserController@notificationRead')->name('notification.read');
            Route::get('notifications/read-all','UserController@readAll')->name('notifications.readAll');


            // Deposit

            Route::any('/deposit', 'Gateway\PaymentController@deposit')->name('deposit');
            Route::post('deposit/insert', 'Gateway\PaymentController@depositInsert')->name('deposit.insert');
            Route::get('deposit/check', 'Gateway\PaymentController@depositPreview')->name('deposit.preview');
            Route::get('deposit/start', 'Gateway\PaymentController@depositConfirm')->name('deposit.confirm');
            Route::get('deposit/providing', 'Gateway\PaymentController@manualDepositConfirm')->name('deposit.manual.confirm');
            Route::post('deposit/manual', 'Gateway\PaymentController@manualDepositUpdate')->name('deposit.manual.update');
            Route::get('deposit/history', 'UserController@depositHistory')->name('deposit.history');

            // Withdraw
            Route::get('/bonus', 'UserController@bonus')->name('bonus');
            Route::get('/withdraw', 'UserController@withdrawMoney')->name('withdraw');
            Route::post('/withdraw', 'UserController@withdrawStore')->name('withdraw.money');
            Route::get('/withdraw/check', 'UserController@withdrawPreview')->name('withdraw.preview');
            Route::post('/withdraw/preview', 'UserController@withdrawSubmit')->name('withdraw.submit');
            Route::get('/withdraw/history', 'UserController@withdrawLog')->name('withdraw.history');


            //Message
            Route::group(['prefix' => '/messages'],  function () {
                Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
                Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
                Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
                Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
                Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
            });

            //Plans
            Route::get('plan', 'UserController@plans')->name('plans');
            Route::post('plans/buy', 'UserController@buyPlan')->name('buyPlan');

            //Help
            Route::get('Help', 'UserController@Help')->name('Help');
            Route::post('daily-checkin', 'UserController@dailyCheckin')->name('checkin');

            // Survey
            Route::get('opinion', 'SurveyController@survey')->name('survey');
            Route::get('opinion/{id}', 'SurveyController@startSurvey')->name('start.survey');
            Route::post('store/survey', 'SurveyController@storeSurvey')->name('store.survey');
            Route::get('all/history', 'SurveyController@history')->name('opinion.history');
            // Microjob
            Route::resource('microJobs', 'MicrojobController');
            Route::resource('jobHistory', 'JobHistoryController');

            //develop
            Route::get('develop', 'UserController@develop')->name('develop');
            Route::get('guide', 'UserController@Guide')->name('guide');
            //PTC
            Route::get('newsview', 'PtcController@index')->name('ptc.index');
            Route::get('newsview-show/{hash}', 'PtcController@show')->name('ptc.show');
            Route::get('newsview-confirm/{hash}', 'PtcController@confirm')->name('ptc.confirm');
            Route::get('newsview/history', 'PtcController@clicks')->name('ptc.clicks');

            //Forum
            Route::get('create/post', 'ForumController@postForm')->name('post.form');
            Route::post('create/post', 'ForumController@postCreate')->name('post.create');
            Route::get('update/post/{id}', 'ForumController@updatePostForm')->name('post.update.form');
            Route::post('update/post/', 'ForumController@updatePost')->name('post.update');
            Route::post('delete/topic/', 'ForumController@deletePost')->name('post.delete');
            Route::get('forum/post', 'ForumController@posts')->name('post.all');
            Route::post('forum/reaction', 'ForumController@reaction')->name('reaction');
            Route::post('forum/comment', 'ForumController@comment')->name('comment');

            // Transaction
            Route::get('transactions', 'UserController@transactions')->name('transactions');

            // Commissions
            Route::get('commissions', 'UserController@commissions')->name('commissions');

            // Referred Users
            Route::get('refer/userlist', 'UserController@referredUsers')->name('referred');
        });
    });
});
Route::get('guide', 'SiteController@Guide')->name('guide');
Route::get('faq', 'SiteController@faq')->name('faq');
Route::get('how-it-works', 'SiteController@howItWorks')->name('how.it.works');
Route::get('leaderboard', 'SiteController@leaderboard')->name('leaderboard');
Route::post('subscribe', 'SiteController@subscribe')->name('subscribe');
Route::get('/contact', 'SiteController@contact')->name('contact');
Route::post('/contact', 'SiteController@contactSubmit')->name('contact.send');
Route::get('change-lang/{code}', 'SiteController@lang');

Route::get('about', 'SiteController@about')->name('about');
Route::get('blog', 'SiteController@blog')->name('blog');
Route::get('/{id}/{title}', 'SiteController@blogDetail')
        ->where(['id' => '[0-9]+', 'name' => '[a-z]+'])->name('blogDetail');
Route::get('Payment', 'SiteController@Payment')->name('Payment');

Route::get('ad-redirect/{hash}','SiteController@adRedirect')->name('adRedirect');
Route::get('forum/{slug}/{id}','SiteController@forum')->name('forum');
Route::get('category/{slug}/{id}','SiteController@categoryPosts')->name('category.post');
Route::get('sub/category/{slug}/{id}','SiteController@subCategoryPosts')->name('sub.category.post');
Route::get('forum/{slug}/{id}','SiteController@postDetails')->name('post.details');
Route::post('load/more/comments', 'SiteController@moreComment')->name('more.comment');

Route::get('user/{username}/{id}','SiteController@user')->name('user');
Route::get('user/post/{username}/{id}','SiteController@userTopics')->name('user.topics');
Route::get('user/answered/{username}/{id}','SiteController@userAnswer')->name('user.answer');
Route::get('user/positive-vote/{username}/{id}','SiteController@userUpVote')->name('user.up.vote');
Route::get('user/negative-vote/{username}/{id}','SiteController@userDownVote')->name('user.down.vote');
Route::get('community', 'SiteController@allPost')->name('post.all');
Route::get('/', 'SiteController@index')->name('home');
Route::get('/{slug}', 'SiteController@pages')->name('home.pages');
Route::get('company-policy/{id}/{slug}', 'SiteController@policy')->name('links');








