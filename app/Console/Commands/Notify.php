<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\NotifyEmail;
class Notify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notify user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('expire', 1)->get(); //collection of users
        foreach ( $users as $user) {
            $user->update(['expire' => 0]);
        }
        $emails = User::pluck('email')->toArray();
        // $data   = [ 'title' => 'programming', 'body' => 'php'];
        foreach($emails as $email) {
            // how to send emails in laravel
            Mail::To($email)->send(new NotifyEmail());
        }
    }
}
