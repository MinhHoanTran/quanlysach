<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckRemind;

class RemindReturnBook extends Command
{
    protected $signature = 'run:remind-to-return-book';
    
    protected $description = 'Send a reminder message to return the book to the user';

    public function handle()
    {
        dispatch(new CheckRemind());
        $this->info('Email remind to return the book sent successfully!');
    }
}
