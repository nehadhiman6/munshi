<?php

namespace App\Http\Controllers\Select;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masters\City;
use App\Models\Masters\RealEstateAgent;
use App\Models\Masters\Employee;
use App\Models\Masters\Contact;
use App\Models\Masters\Brokerage;
use App\Models\Masters\LawFirm;
use App\Models\Masters\Solicitor;
use App\Models\Masters\TransactionType;
use App\Models\Masters\PrecedentFormat;
use App\Models\Matters\FileDocument;

class SelectController extends Controller
{
    public function getCities(Request $request)
    {
        $rows = 30;
        if ($request->has('term')) {
            $search = $request->has('term') ? $request->input('term', '') : '';
        } else {
            $search = $request->input('search', '');
        }
        $list = City::where('city_name', 'like', '%' . $search . '%')
            ->orderBy('city_name');

        if ($request->has('lro_id') && $request->lro_id > 0) {
            $list = $list->where('lro_id', $request->lro_id);
        }
        $count_filtered = $list->count();

        if ($request->has('page')) {
            if ($request->page > 1) {
                $list->skip(($request->page - 1) * $rows);
            }
            $list = $list->take($rows);
        }

        $list = $list->get();
        return reply(true, [
            'results' => $list,
            'count_filtered' => $count_filtered
        ]);
    }


    public function getRealEstateAgent(Request $request)
    {
        $rows = 30;
        if ($request->has('term')) {
            $search = $request->has('term') ? $request->input('term', '') : '';
        } else {
            $search = $request->input('search', '');
        }
        $list = RealEstateAgent::where(function ($q) use ($search) {
            $q->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('middle_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%');;
        })
            ->orderBy('first_name');
        $count_filtered = $list->count();

        if ($request->has('page')) {
            if ($request->page > 1) {
                $list->skip(($request->page - 1) * $rows);
            }
            $list = $list->take($rows);
        }

        $list = $list->get();
        return reply(true, [
            'results' => $list,
            'count_filtered' => $count_filtered
        ]);
    }

    public function getEmployee(Request $request)
    {
        $rows = 30;
        if ($request->has('term')) {
            $search = $request->has('term') ? $request->input('term', '') : '';
        } else {
            $search = $request->input('search', '');
        }
        $list = Employee::where(function ($q) use ($search) {
            $q->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('middle_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%');
        })
            ->orderBy('first_name');
        $count_filtered = $list->count();

        if ($request->type && $request->type != '') {
            $list = $list->where('type', '=', $request->type);
        }

        if ($request->has('page')) {
            if ($request->page > 1) {
                $list->skip(($request->page - 1) * $rows);
            }
            $list = $list->take($rows);
        }

        $list = $list->get();
        return reply(true, [
            'results' => $list,
            'count_filtered' => $count_filtered
        ]);
    }

    public function getContact(Request $request)
    {
        $rows = 30;
        if ($request->has('term')) {
            $search = $request->has('term') ? $request->input('term', '') : '';
        } else {
            $search = $request->input('search', '');
        }
        $list = Contact::where(function ($q) use ($search) {
            $q->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('middle_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('company_name', 'like', '%' . $search . '%');
        })
            ->orderBy('first_name');
        $count_filtered = $list->count();

        if ($request->has('type') && $request->type != '') {
            $list = $list->where('type', $request->type);
        }

        if ($request->has('page')) {
            if ($request->page > 1) {
                $list->skip(($request->page - 1) * $rows);
            }
            $list = $list->take($rows);
        }

        $list = $list->get();
        return reply(true, [
            'results' => $list,
            'count_filtered' => $count_filtered
        ]);
    }

    public function getBrokerage(Request $request)
    {
        $rows = 30;
        if ($request->has('term')) {
            $search = $request->has('term') ? $request->input('term', '') : '';
        } else {
            $search = $request->input('search', '');
        }
        $list = Brokerage::where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        })
            ->orderBy('name');
        $count_filtered = $list->count();


        if ($request->has('page')) {
            if ($request->page > 1) {
                $list->skip(($request->page - 1) * $rows);
            }
            $list = $list->take($rows);
        }

        $list = $list->with('address.city')->get();
        return reply(true, [
            'results' => $list,
            'count_filtered' => $count_filtered
        ]);
    }

    public function getCreditType(Request $request)
    {
        $rows = 30;
        if ($request->has('term')) {
            $search = $request->has('term') ? $request->input('term', '') : '';
        } else {
            $search = $request->input('search', '');
        }
        $list = TransactionType::where(function ($q) use ($search) {
            $q->where('type_name', 'like', '%' . $search . '%');
        })
            ->orderBy('type_name');
        $count_filtered = $list->count();


        if ($request->has('page')) {
            if ($request->page > 1) {
                $list->skip(($request->page - 1) * $rows);
            }
            $list = $list->take($rows);
        }

        $list = $list->get();
        return reply(true, [
            'results' => $list,
            'count_filtered' => $count_filtered
        ]);
    }

    public function getLawFirms(Request $request)
    {
        $rows = 30;
        if ($request->has('term')) {
            $search = $request->has('term') ? $request->input('term', '') : '';
        } else {
            $search = $request->input('search', '');
        }
        $list = LawFirm::where(function ($q) use ($search) {
            $q->where('firm_name', 'like', '%' . $search . '%');
        })
            ->orderBy('firm_name');
        $count_filtered = $list->count();


        if ($request->has('page')) {
            if ($request->page > 1) {
                $list->skip(($request->page - 1) * $rows);
            }
            $list = $list->take($rows);
        }

        $list = $list->with('address')->get();
        return reply(true, [
            'results' => $list,
            'count_filtered' => $count_filtered
        ]);
    }

    public function getSolicitors(Request $request)
    {
        $rows = 30;
        if ($request->has('term')) {
            $search = $request->has('term') ? $request->input('term', '') : '';
        } else {
            $search = $request->input('search', '');
        }
        $list = Solicitor::where(function ($q) use ($search) {
            $q->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('middle_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%');
        })
            ->orderBy('first_name');
        $count_filtered = $list->count();


        if ($request->has('page')) {
            if ($request->page > 1) {
                $list->skip(($request->page - 1) * $rows);
            }
            $list = $list->take($rows);
        }

        $list = $list->get();
        return reply(true, [
            'results' => $list,
            'count_filtered' => $count_filtered
        ]);
    }


    public function getCanadianStates(Request $request)
    {
        $rows = 30;

        $list = canadianStates();
        $count_filtered = count($list);

        return reply(true, [
            'results' => $list,
            'count_filtered' => $count_filtered
        ]);
    }

    public function getPrecedents(Request $request)
    {
        $rows = 30;
        if ($request->has('term')) {
            $search = $request->has('term') ? $request->input('term', '') : '';
        } else {
            $search = $request->input('search', '');
        }
        $list = PrecedentFormat::where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        })
            ->orderBy('name');
        $count_filtered = $list->count();


        if ($request->has('page')) {
            if ($request->page > 1) {
                $list->skip(($request->page - 1) * $rows);
            }
            $list = $list->take($rows);
        }

        $list = $list->get();
        return reply(true, [
            'results' => $list,
            'count_filtered' => $count_filtered
        ]);
    }

    public function getDocumentFileTypes(Request $request)
    {
        $rows = 30;
        if ($request->has('term')) {
            $search = $request->has('term') ? $request->input('term', '') : '';
        } else {
            $search = $request->input('search', '');
        }
        $list = FileDocument::where(function ($q) use ($search) {
            $q->where('doc_type', 'like', '%' . $search . '%');
        })
            ->orderBy('doc_type');
        $count_filtered = $list->count();


        if ($request->has('page')) {
            if ($request->page > 1) {
                $list->skip(($request->page - 1) * $rows);
            }
            $list = $list->take($rows);
        }

        $list = $list->get();
        return reply(true, [
            'results' => $list,
            'count_filtered' => $count_filtered
        ]);
    }

    // public function getLROs(Request $request){
    //     $list = lotNumbers();
    //     usort($list, function($a, $b)
    //     {
    //         return strcmp($a['text'], $b['text']);
    //     });


    //     return reply(true, [
    //         'results' => $list,
    //         'count_filtered' => count($list)
    //     ]);
    // }
}
