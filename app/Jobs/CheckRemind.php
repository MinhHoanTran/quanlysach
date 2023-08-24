<?php

namespace App\Jobs;

use App\Mail\RemindMail;
use App\Models\BorrowedBook;
use Illuminate\Support\Carbon;
use App\Models\UserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\HTMLToMarkdown\HtmlConverter;

class CheckRemind implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    
     public function handle()
     {
        $listnotsend = UserNotification::where('status', '0')->get();
        foreach ($listnotsend as $notification){
            $notification->delete();
        }

        $listdue = BorrowedBook::where('status', 'Đang mượn')
             ->where('return_date', '<=', Carbon::today()->addDays(5))
             ->with('user')
             ->get();
     
         $listdueByUser = $listdue->groupBy('user_id');
         $userReminders = $listdueByUser->map(function ($books) {
             $user = $books->first()->user;
     
             return [
                 'user' => $user,
                 'books' => $books,
             ];
         });
         
         foreach ($userReminders as $reminder) {
             $user = $reminder['user'];
             $books = $reminder['books'];

             $emailContent = view('emails.remind', ['user' => $user, 'books' => $books])->render();     
             $userNotification = new UserNotification();
                $userNotification->user_id = $user->id;
                $userNotification->content = $emailContent;
                $userNotification->available_time = Carbon::now();
                $userNotification->status = '0';  
                $userNotification->save();
         }
     }
}