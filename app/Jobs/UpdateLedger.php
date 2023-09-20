<?php

namespace App\Jobs;

use App\Models\Company\Company;
use App\Models\Liesure\Leisure;
use App\Models\Matters\FileOpening;
use App\Services\SendDataService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateLedger implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $file_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file_id)
    {
        $this->file_id = $file_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = FileOpening::find($this->file_id);
        if ($file && intval($file->rate) == 0) {
            $file_no = FileOpening::where('id', '<=', $this->file_id)->count();
            $rate = getFileRate($file_no);
            if ($rate != 0) {
                $hst_rate = getHstRate();
                $hst_amt = round($rate * $hst_rate / 100, 2);
                $file->rate = $rate + $hst_amt;
                $comp = Company::first();
                $ledger = new Leisure();
                $ledger->vcode = 'FO' . $file->id;
                $ledger->file_id = $this->file_id;
                $ledger->trans_date = Carbon::createFromFormat('Y-m-d H:i:s', $file->created_at)->format('m-d-Y');
                $ledger->particulars = 'Charges against File No.' . $file->file_no;
                $ledger->dr_amount = $rate + $hst_amt;
                $ledger->cr_amount = 0;
                $ledger->hst_rate = $hst_rate;
                $ledger->hst_amt = $hst_amt;
                $ledger->organization_id = $comp->organization_id;
                DB::beginTransaction();
                $file->save();
                $ledger->save();
                DB::commit();
            }
        }
    }

    private function getFileRate($data, $file_no)
    {
        $file_qty = 0;
        $rate = 0;
        foreach ($data as $val) {
            if ($file_no > $file_qty && $file_no <= $file_qty + intval($val['no_of_files'])) {
                $rate = $val['rate'];
            }
            $file_qty += intval($val['no_of_files']);
        }
        return $rate;
    }
}
