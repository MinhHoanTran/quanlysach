<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class SendEmailRemind implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    
     public function handle(){
        $usernotification = UserNotification::where('status', '0')
        ->with('user')
        ->get();

        foreach ($usernotification as $users) {
            $userEmail = $users->user->email;

            $emailContent = $users->content;
            try {
                Mail::send([], [], function ($message) use ($userEmail, $emailContent) {
                    $message->to($userEmail)
                        ->subject('Thông báo đến hạn trả sách')
                        ->setBody($emailContent, 'text/html');
                });
            
                $users->status = 1;
                $users->save();
                Storage::delete($users->content);
            } catch (\Exception $e) {
                sleep(3);
            }
            
        }
    }
}
