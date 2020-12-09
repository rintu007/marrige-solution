<?php

namespace App\Console\Commands;

use Mail;
use Carbon\Carbon;
use App\Model\User;
use Illuminate\Console\Command;
use App\Model\UsersForAutoMail;

class AutomailToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'automailtousers:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto mail send to users';

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
     * @return mixed
     */
    public function handle()
    {
        if(env('APP_ENV') != 'local')
        { 

            Mail::send('emails.email', [], function ($message) {
                            $message->from('mail@taslimamarriagemedia.com', url('/'));
                            $message->to('masudbdm@gmail.com', url('/'))
                            ->subject('Project testing from... '.url('/'));
                        });


            // $end = Carbon::now()->toDateString();
                // $start = Carbon::now()->subDays(6)->toDateString();

                // $date = Carbon::now()->toDateString(); //for test
                $date = Carbon::now()->subDays(6)->toDateString(); //for 7 day old data
                $start = $date.' 00:00:00';
                $end = $date.' 23:59:59';

            $userLogs = UsersForAutoMail::where('subscribed', 1)
                    // ->where('updated_at', '>=', $date.' 00:00:00')
                    // ->where('updated_at', '<=', $date.' 23:59:59')
                    ->whereBetween('updated_at',[$start,$end])
                    ->get();

            if($userLogs->count())
            {
                foreach($userLogs as $log)
                {

                    // Mail::send('emails.test',['log'=>$log], function ($message) use ($log)  {
                    //     $message->from('mail@justlynk.com', 'LYNK™');

                    //     $message->to($log->user->email, $log->user->name)
                    //     ->subject("{$log->directory->title} is published in bd.justlynk.com");
                    // });





                    $user = $log->user;
                    $log->mail_count = $log->mail_count + 1;
                    $log->updated_at = Carbon::now();
                    // $log->save();





                    // Mail::send('emails.directory.new_user_data', ['user' => $user, 'directory' => $directory,'password'=>$password], function ($message) use ($user,$directory) {
                    //     $message->from('mail@justlynk.com', 'LYNK™');
                    //     $message->to($user->email, $user->name)
                    //     ->subject("{$directory->title} is published in bd.justlynk.com");
                    // });

                }
            }
        }

        $this->info('Email sent to new user successfully!');
    }
}
