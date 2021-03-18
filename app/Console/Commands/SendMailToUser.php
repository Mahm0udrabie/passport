<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
class SendMailToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email to user about site updates';

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
        $users = User::where('expire', 0)->get(); //collection of users
        foreach ( $users as $user) {
            $user->update(['expire' => 1]);
        }
    }
}
