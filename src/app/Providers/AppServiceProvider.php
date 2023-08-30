<?php

namespace App\Providers;

use App\Enums\StatusEnum;
use App\Models\Core\Language;
use App\Models\Ticket;
use App\Models\Visitor;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Admin\Service;
use App\Models\Admin\Portfolio;
use App\Models\Admin\Process;
use App\Models\Admin\Team;

class AppServiceProvider extends ServiceProvider
{
    
    /**
     * Register any application services.
     */
    public function register(): void
    {
 

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            Paginator::useBootstrap();
            if(env("APP_DEBUG")){
                Config::set('sentry',[
                    'dns' => site_settings('sentry_dns')
                ]);
            }
      
    
            view()->composer('admin.partials.sidebar', function ($view)  {
         
                $view->with([
                    
                    'pending_tickets'=> Ticket::pending()->count(),
                ]);
            });
            $services = Service::active()->get();
            $portfolios = Portfolio::active()->get();
            $processes = Process::active()->get();
            $teams = Team::active()->get();
            view()->composer('frontend.sections.service', function ($view) use($services)  {
                $view->with([
                    "services"=> $services,
                ]);
            });
            view()->composer('frontend.sections.portfolio', function ($view) use($portfolios)  {
                $view->with([
                    "portfolios"=> $portfolios,
                ]);
            });
            view()->composer('frontend.sections.process', function ($view) use($processes)  {
                $view->with([
                    "processes"=> $processes,
                ]);
            });
            view()->composer('frontend.sections.team_section', function ($view) use($teams)  {
                $view->with([
                    "teams"=> $teams,
                ]);
            });
            view()->composer('frontend.sections.counter', function ($view)  {
                $counter = array();

                $counter ['total_visitor'] = Visitor::count();
             

                $view->with([
                    "counter"=> $counter,
                ]);
            });

            view()->share([
                'languages' => Language::where('status',(StatusEnum::true)->status())->get(), 
            ]);
            
        } catch (\Throwable $th) {
        
        }
    }
}
