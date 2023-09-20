<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Matters\FileOpening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileFeeReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!request()->ajax()) {
            return view('reports.file_fee_report');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (intval($request->month == 0)) {
            $rules = [
                'from_date' => 'required|date_format:m-d-Y',
                'to_date' => 'required|date_format:m-d-Y',
            ];
        } else {
            $rules = [
                'month' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12'
            ];
        }
        $this->validate($request, $rules);
        $hst_rate = getHstRate();
        $files = FileOpening::select(
            DB::raw("sum(1) as files_qty"),
            DB::raw("sum(rate) as amount"),
            DB::raw("sum(round(rate*$hst_rate/100,2)) as hst_amt"),
            DB::raw("sum(round(rate*(100+$hst_rate)/100,2)) as tot_amt"),
        );
        $data = FileOpening::select(
            DB::raw("cast(created_at as date) as date"),
            'file_no',
            'client_name',
            DB::raw("'' as ref"),
            'rate'
        );
        if (intval($request->month == 0)) {
            $dt1 = getFormattedDate($request->from_date, 'm-d-Y', 'Y-m-d');
            $dt2 = getFormattedDate($request->to_date, 'm-d-Y', 'Y-m-d');
            $files = $files->whereBetween(DB::raw("cast(created_at as date)"), [$dt1, $dt2]);
            $data = $data->whereBetween(DB::raw("cast(created_at as date)"), [$dt1, $dt2]);
        } else {
            $files = $files->where(DB::raw("month(created_at)"), $request->month);
            $data = $data->where(DB::raw("month(created_at)"), $request->month);
        }
        $files = $files->first();
        $data = $data->get();
        return reply('OK', compact('files', 'data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
