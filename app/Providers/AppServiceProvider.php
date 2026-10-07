<?php

namespace App\Providers;

use App\Models\Attachment;
use App\Models\Channel;
use App\Models\Company;
use App\Models\Expense;
use App\Models\Groups;
use App\Models\Message;
use App\Models\Settlements;
use App\Models\Team;
use App\Policies\AttachmentPolicy;
use App\Policies\ChannelPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\ExpensePolicy;
use App\Policies\GroupPolicy;
use App\Policies\MessagePolicy;
use App\Policies\SettlementPolicy;
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

        Gate::policy(Groups::class, GroupPolicy::class);
        Gate::policy(Expense::class, ExpensePolicy::class);
        Gate::policy(Settlements::class, SettlementPolicy::class);
        Gate::policy(Attachment::class, AttachmentPolicy::class);
       
    }
      


  
}
