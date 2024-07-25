<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserInactiveMail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\User;
use Modules\Question\Entities\Question;
use Modules\Reaction\Entities\Reaction;
use Modules\Share\Entities\Share;
use Modules\Points\Entities\PointManage;
class SendInactiveMail extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:sent_inactive_mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send user mail if not logged in for past 3 months';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
// three month mail
        $current_date = Carbon::now()->subMonth()->subMonth()->subMonth();

        $users = User::whereNotNull('email')->where('notification', 0)->where('date', '!=', '')->where('role_id', '!=', 1)->where('date', '<', $current_date->format('Y-m-d H:i'))->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new UserInactiveMail($user));
            $user->update(['notification' => 1]);
        }

        // one month mail
        $current_date = Carbon::now()->subMonth();
        $today = \Carbon\Carbon::now(); //Current Date and Time
        $lastDayofMonth = \Carbon\Carbon::parse($today)->endOfMonth()->toDateString();

        $allUsers = User::whereNotNull('email')->get();
        foreach ($users as $user) {
            if (Auth::user()->isStudent()) {
                $amout = $submitManage = PointManage::whereUserId($user['id'])->orderBy('created_at', 'DESC')->get()->sum('points');
               
               
            } else {
                $ids = [];
                $user = $user;
                $childrens = $user->children;
                foreach ($childrens as $children) {
                    $ids[] = $children['id'];
                }
                $amout = PointManage::whereIn('user_id', $ids)->orderBy('created_at', 'DESC')->get()->sum('points');
              
            }
            $Reaction = Reaction::whereUserId($user['id'])->count();
            $Share = Share::whereUserId($user['id'])->count();
            $Question = Question::whereUserId($user['id'])->count();
            $points = $amout;
            $reaction = $Reaction;
            $Submissions = $Share;
            $Questions = $Question;
            $image = Auth::user()['image'];
            $Visit = $user['visit'];
            $email = $user['email'];
            $name = $user['first_name'] . $user['last_name'];
            $data = ['data' => (object) ['points' => $points, 'name' => $name, 'reaction' => $reaction, 'Submissions' => $Submissions,
                    'Questions' => $Questions, 'Visit' => $Visit, 'image' => $image, 'email' => $email]];

            \Mail::send('MonthlyTemplate', $data, function ($m) use ($email) {
                $m->to($email)->subject('Monthly Round Up!');
            })->everyMinute();
        }
    }

}
