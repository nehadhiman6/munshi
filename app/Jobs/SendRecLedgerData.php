<?php

namespace App\Jobs;

use App\Models\AppSettings;
use App\Models\Company\Company;
use App\Models\Liesure\Leisure;
use App\Models\Organization;
use App\Services\SendDataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SendRecLedgerData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lgrs = Leisure::where(DB::raw("ifnull(leisure_id,0)"), 0)->get();
        $comp = Company::first();
        $data['lgrs'] = $lgrs;
        $data['organization_id'] = $comp->organization_id;
        $result = AppSettings::getValue('ledgers_updated');
        if ($result) {
            $data['result'] = json_decode($result, true);
        } else {
            $data['result'] = [];
        }
        $service = new SendDataService();
        $data = $service->sendRecLedgerData($data);
        $data = json_decode($data, true);
        $result = [];
        $ledgers = [];
        $res_ledgers = [];
        if (array_key_exists('data', $data)) {
            $lgrs = $data['data'];
            if (count($lgrs) > 0) {
                foreach ($lgrs as $val) {
                    $lgr = Leisure::firstOrNew(['leisure_id' => $val['id']]);
                    $lgr->fill($val);
                    $lgr->leisure_id = $val['id'];
                    $ledgers[] = $lgr;
                }
            }
        }
        if (array_key_exists('result', $data)) {
            $lgrs = $data['result'];
            if (count($lgrs) > 0) {
                foreach ($lgrs as $key => $val) {
                    $lgr = Leisure::find($key);
                    if ($lgr) {
                        $lgr->leisure_id = $val;
                        $res_ledgers[] = $lgr;
                    }
                }
            }
        }
        $organization = null;
        if (array_key_exists('organization', $data)) {
            $org = $data['organization'];
            if ($org) {
                $organization = Organization::firstOrNew(['organization_id' => $org['id']]);
                $organization->fill($org);
                $organization->organization_id = $org['id'];
            }
        }
        DB::beginTransaction();
        foreach ($res_ledgers as $lgr) {
            $lgr->save();
        }
        foreach ($ledgers as $lgr) {
            $lgr->save();
            $result[$lgr->leisure_id] = $lgr->id;
        }
        if ($organization) {
            $organization->save();
        }
        AppSettings::setValue('ledgers_updated', json_encode($result));
        DB::commit();
    }
}
