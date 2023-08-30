<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CommunicationsController;
use App\Http\Controllers\Admin\FrontendManageController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\MailGatewayController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ProcessController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;


Route::middleware(['sanitizer'])->prefix('admin')->name('admin.')->group(function () {

     #guest admin route start here
	Route::middleware(['guest:admin'])->group(function () {
          #login route
          Route::controller(LoginController::class)->group(function () {
               Route::get('/', 'login')->name('login');
               Route::post('/authenticate', 'authenticate')->name('authenticate');
          });

            #password route
          Route::controller(NewPasswordController::class)->name('password.')->group(function () {
               Route::get('forgot-password', 'create')->name('request');
               Route::post('password/email','store')->name('email');
               Route::get('password/verify','verify')->name('verify');
               Route::post('password/verify/code','verifyCode')->name('verify.code');
               Route::get('password/reset', 'resetPassword')->name('reset');
               Route::post('password/update', 'updatePassword')->name('update.request');
          });

     });

     $hitLimit = 500;
      try {
          $hitLimit = site_settings('web_route_rate_limit');
      } catch (\Throwable $th) {
          //throw $th;
      }

	Route::middleware(['auth:admin',"throttle:$hitLimit,1",'demo','last.login','admin.verified'])->group(function () {

          Route::controller(LoginController::class)->group(function () {
               Route::get('/logout', 'logout')->name('logout');
          });

          #home & profile route
          Route::controller(HomeController::class)->group(function(){

               Route::any('dashboard','home')->name('home');
               Route::prefix('profile')->name('profile.')->group(function () {
                    Route::get('/','profile')->name('index');
                    Route::post('/update', 'profileUpdate')->name('update');
               });

               Route::prefix('passwords')->name('password.')->group(function () {
                    Route::post('/update', 'passwordUpdate')->name('update');
               });

               Route::get('/notifications','notification')->name('notifications');
               Route::post('/read-notification','readNotification')->name('read.notification');
          });

          #Staff Route
          Route::controller(StaffController::class)->prefix("/staff")->name('staff.')->group(function(){

               Route::get('/list','index')->name('list');
               Route::post('/store','store')->name('store');
               Route::post('/update','update')->name('update');
               Route::post('/update/status','updateStatus')->name('update.status');
               Route::post('/update/password','updatePassword')->name('update.password');
               Route::get('/destroy/{uid}','destroy')->name('destroy');
               Route::post('/bulk/action','bulk')->name('bulk');
               Route::get('/login/{uid}','login')->name('login');
               Route::get('/force-destroy/{id}','forceDestroy')->name('force.destroy')->withTrashed();
               Route::post('/restore/{id}','restore')->name('restore')->withTrashed();
               Route::get('/archive','index')->name('archive');
          });

          #Role
          Route::controller(RoleController::class)->prefix("/role")->name('role.')->group(function(){

               Route::get('/list','index')->name('list');
               Route::get('/create','create')->name('create');
               Route::post('/store','store')->name('store');
               Route::get('/edit/{uid}','edit')->name('edit');
               Route::post('/update','update')->name('update');
               Route::post('/bulk/action','bulk')->name('bulk');
               Route::post('/update/status','updateStatus')->name('update.status');
               Route::get('/destroy/{uid}','destroy')->name('destroy');
               Route::get('/force-destroy/{id}','forceDestroy')->name('force.destroy')->withTrashed();
               Route::post('/restore/{id}','restore')->name('restore')->withTrashed();
               Route::get('/archive','index')->name('archive');
          });

          #Template
          Route::controller(TemplateController::class)->prefix("/template")->name('template.')->group(function(){

               Route::get('/list','index')->name('list');
               Route::get('/edit/{uid}','edit')->name('edit');
               Route::post('/update','update')->name('update');
               Route::post('/update/status','updateStatus')->name('update.status');
               Route::get('/global','global')->name('global');
              Route::post('/global-update','globalUpdate')->name('global.update');
               Route::post('/bulk/action','bulk')->name('bulk');
              Route::get('/destroy/{uid}','destroy')->name('destroy');
              Route::get('/force-destroy/{id}','forceDestroy')->name('force.destroy')->withTrashed();
              Route::post('/restore/{id}','restore')->name('restore')->withTrashed();
              Route::get('/archive','index')->name('archive');
          });

          #Email gateway
          Route::controller(MailGatewayController::class)->prefix("/mail-gateway")->name('mailGateway.')->group(function(){

               Route::get('/list','index')->name('list');
               Route::get('/edit/{uid}','edit')->name('edit');
               Route::post('/update','update')->name('update');
               Route::post('/update/status','updateStatus')->name('update.status');
               Route::post('/test','test')->name('test');
          });

          #Language
          Route::controller(LanguageController::class)->prefix("/language")->name('language.')->group(function(){

               Route::get('/list','index')->name('list');
               Route::post('/store','store')->name('store');
               Route::post('/update/status','updateStatus')->name('update.status');
               Route::post('/update/direction','updateDirection')->name('update.direction');
               Route::get('/make/default/{uid}','setDefaultLang')->name('make.default');
               Route::get('/destroy/{uid}','destroy')->name('destroy');
               Route::get('translate/{code}','translate')->name('translate');
               Route::post('translate-key','tranlateKey')->name('tranlateKey');
               Route::post('/bulk/action','bulk')->name('bulk');
               Route::get('destroy/translate-key/{id}','destroyTranslateKey')->name('destroy.key');
              Route::get('/force-destroy/{id}','forceDestroy')->name('force.destroy')->withTrashed();
              Route::post('/restore/{id}','restore')->name('restore')->withTrashed();
              Route::get('/archive','index')->name('archive');
          });

          #General Setting
          Route::controller(SettingController::class)->prefix('settings')->name('setting.')->group(function () {

               Route::get('/', 'index')->name('list');
               Route::post('/store', 'store')->name('store');
               Route::post('/ticket/store', 'ticketSetting')->name('ticket.store');
               Route::post('/register/store', 'registerSetting')->name('register.store');
               Route::post('/plugin/store', 'pluginSetting')->name('plugin.store');
               Route::post('/logo/store', 'logoSetting')->name('logo.store');
               Route::post('/update/status', 'updateStatus')->name('update.status');
               Route::get('/cache/clear', 'cacheClear')->name('cache.clear');

               #System Configuration
               Route::prefix('configurations')->name('configuration.')->group(function () {
                   Route::get('/', 'systemConfiguration')->name('index');
               });
               Route::get('system/info','systemInfo')->name('system.info');
           });

          #Frontend section
          Route::controller(FrontendManageController::class)->prefix("/frontend")->name('frontend.')->group(function(){

               Route::get('/list','index')->name('list');
               Route::post('/update','update')->name('update');
               Route::get('/visitor','visitor')->name('visitor');
               Route::post('/visitor/ip-status','updateStatus')->name('visitor.ip.status');
               Route::get('/destroy-ip/{ip}','destroyIp')->name('ip.destroy');
              Route::post('/visitor/bulk/action','bulk')->name('visitor.bulk');
              Route::get('/visitor/force-destroy/{id}','forceDestroy')->name('visitor.force.destroy')->withTrashed();
              Route::post('/visitor/restore/{id}','restore')->name('visitor.restore')->withTrashed();
              Route::get('/visitor/archive','visitor')->name('visitor.archive');
          });

          #Seo section
          Route::controller(FrontendManageController::class)->prefix("/seo")->name('seo.')->group(function(){

               Route::get('/list','seo')->name('list');
               Route::get('/edit/{uid}','edit')->name('edit');
               Route::post('/update','updateSeo')->name('update');
          });

          #ads section
          Route::controller(FrontendManageController::class)->prefix("/ads")->name('ad.')->group(function(){

               Route::get('/list','ads')->name('list');
               Route::get('/edit/{uid}','editAd')->name('edit');
               Route::post('/update/status','updateAdStatus')->name('update.status');
               Route::post('/update','updateAd')->name('update');
          });

          #Service Section
          Route::controller(ServiceController::class)->prefix("/service")->name('service.')->group(function (){
               Route::get('/list', 'index')->name('list');
               Route::get('/create','create')->name('create');
               Route::post('/store','store')->name('store');
               Route::post('/update','update')->name('update');
               Route::post('/update/status','updateStatus')->name('update.status');
               Route::get('/edit/{uid}','edit')->name('edit');
               Route::post('/bulk/action','bulk')->name('bulk');
               Route::get('/destroy/{uid}','destroy')->name('destroy');
           
          });
          #Portfolio Section
          Route::controller(PortfolioController::class)->prefix("/portfolio")->name('portfolio.')->group(function (){
               Route::get('/list', 'index')->name('list');
               Route::get('/create','create')->name('create');
               Route::post('/store','store')->name('store');
               Route::post('/update','update')->name('update');
               Route::post('/update/status','updateStatus')->name('update.status');
               Route::get('/edit/{uid}','edit')->name('edit');
               Route::post('/bulk/action','bulk')->name('bulk');
               Route::get('/destroy/{uid}','destroy')->name('destroy');
           
          });
          #Process Section
          Route::controller(ProcessController::class)->prefix("/process")->name('process.')->group(function (){
               Route::get('/list', 'index')->name('list');
               Route::get('/create','create')->name('create');
               Route::post('/store','store')->name('store');
               Route::post('/update','update')->name('update');
               Route::post('/update/status','updateStatus')->name('update.status');
               Route::get('/edit/{uid}','edit')->name('edit');
               Route::post('/bulk/action','bulk')->name('bulk');
               Route::get('/destroy/{uid}','destroy')->name('destroy');
           
          });
          #Team Section
          Route::controller(TeamController::class)->prefix("/team")->name('team.')->group(function (){
               Route::get('/list', 'index')->name('list');
               Route::get('/create','create')->name('create');
               Route::post('/store','store')->name('store');
               Route::post('/update','update')->name('update');
               Route::post('/update/status','updateStatus')->name('update.status');
               Route::get('/edit/{uid}','edit')->name('edit');
               Route::post('/bulk/action','bulk')->name('bulk');
               Route::get('/destroy/{uid}','destroy')->name('destroy');
           
          });
           #Product Section
           Route::controller(ProductController::class)->prefix("/product")->name('product.')->group(function (){
               Route::get('/list', 'index')->name('list');
               Route::get('/create','create')->name('create');
               Route::post('/store','store')->name('store');
               Route::post('/update','update')->name('update');
               Route::post('/update/status','updateStatus')->name('update.status');
               Route::get('/edit/{uid}','edit')->name('edit');
               Route::post('/bulk/action','bulk')->name('bulk');
               Route::get('/destroy/{uid}','destroy')->name('destroy');
           
          });
          #support route
          Route::controller(TicketController::class)->name('ticket.')->prefix('ticket/')->group(function () {

               Route::any('/list','list')->name('list');
               Route::get('/create','create')->name('create');
               Route::post('/store','store')->name('store');
               Route::get('/reply/{ticket_number}','show')->name('show');
               Route::post('/reply/store','reply')->name('reply');
               Route::post('/file/download','download')->name('file.download');
               Route::get('/destroy/{id}','destroy')->name('destroy');
               Route::post('/update','update')->name('update');
               Route::get('/destroy/message/{id}','destroyMessage')->name('destroy.message');
               Route::post('/bulk/action','bulk')->name('bulk');
               Route::get('/destroy/file/{id}','destroyFile')->name('destroy.file');
          });




	});


});

Route::middleware(['sanitizer'])->prefix('staff')->name('staff.')->group(function () {

     #guest admin route start here
	Route::middleware(['guest:staff'])->group(function () {
          #login route
          Route::controller(LoginController::class)->group(function () {
               Route::get('/', 'staffLogin')->name('login');
               Route::post('/authenticate', 'authenticateStaff')->name('authenticate');
          });

            #password route
          Route::controller(NewPasswordController::class)->name('password.')->group(function () {
               Route::get('forgot-password', 'create')->name('request');
               Route::post('password/email','store')->name('email');
               Route::get('password/verify','verify')->name('verify');
               Route::post('password/verify/code','verifyCode')->name('verify.code');
               Route::get('password/reset', 'resetPassword')->name('reset');
               Route::post('password/update', 'updatePassword')->name('update.request');
          });

     });
     $hitLimit = 500;
     try {
         $hitLimit = site_settings('web_route_rate_limit');
     } catch (\Throwable $th) {
         //throw $th;
     }
     Route::middleware(['auth:staff',"throttle:$hitLimit,1",'demo','last.login'])->group(function () {
          Route::controller(LoginController::class)->group(function () {
               Route::get('/logout', 'logoutStaff')->name('logout');
          });
          #home & profile route
          Route::controller(HomeController::class)->group(function(){
               Route::any('dashboard','staffHome')->name('home');
          });
     });
});








