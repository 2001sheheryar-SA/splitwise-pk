<?php

namespace App\Policies;

use App\Models\Channel;
use App\Models\Attachment;
use App\Models\Team;
use App\Models\User;
use App\Services\GroupService;
use Illuminate\Auth\Access\Response;

class AttachmentPolicy
{
    
    public function download (User $user, Attachment $attachment): Response
    {
      
        $ismember=GroupService::isMember($attachment->settlements->group,$user->id);

       if (!$ismember) {
        return Response::deny('This authenticated user is not member of above attachment\'s settlement group.');
        }
         return Response::allow();
    }

    
}
