<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    /**
     * Any member of the company may view it.
     */
    public function view(User $user, Company $company): bool

    {  
    
        return $user->company_id === $company->id;
    }

    /**
     * Only the owner may update company details.
     */
    public function update(User $user, Company $company): bool
    {
        return $user->id === $company->owner_id;
    }
}
