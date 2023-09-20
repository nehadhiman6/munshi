<?php

namespace App\Jobs;

use App\Models\Auth\User;
use App\Models\Company\Company;
use App\Services\SendDataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SetRemoteUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::where(DB::raw("ifnull(remote_user_id,0)"), 0)->get();
        $comp = Company::first();
        $data['users'] = $users;
        $data['organization_id'] = $comp->organization_id;
        $service = new SendDataService();
        $data = $service->setRemoteUser($data);
        $data = json_decode($data, true);
        $users = [];
        if (array_key_exists('result', $data)) {
            $result = $data['result'];
            if (count($result) > 0) {
                foreach ($result as $key => $val) {
                    $user = User::find($key);
                    if ($user) {
                        $user->remote_user_id = $val;
                        $users[] = $user;
                    }
                }
            }
        }
        DB::beginTransaction();
        foreach ($users as $user) {
            $user->save();
        }
        DB::commit();
        //
    }
}
