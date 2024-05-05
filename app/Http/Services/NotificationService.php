<?php

namespace App\Http\Services;

use App\Models\Notification;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    use ResponseTrait;

   public function getNotification(){
    $userId = auth()->id();
    $notifications = Notification::where(function ($query) use ($userId) {
        $query->whereNull('user_id')
            ->orWhere('user_id', $userId);
    })
    ->get();
    return $notifications;
    
   }
}