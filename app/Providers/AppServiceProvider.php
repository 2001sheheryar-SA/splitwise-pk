<?php

namespace App\Providers;


use App\Models\Channel;
use App\Models\Company;
use App\Models\Message;
use App\Models\Team;
use App\Policies\ChannelPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\MessagePolicy;
use App\Policies\TeamPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {    

        Gate::policy(Company::class, CompanyPolicy::class);
        Gate::policy(Team::class, TeamPolicy::class);
        Gate::policy(Channel::class, ChannelPolicy::class);
        Gate::policy(Message::class, MessagePolicy::class);
       
    }
      


  
}
