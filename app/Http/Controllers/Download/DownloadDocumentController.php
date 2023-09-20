<?php

namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DownloadDocumentController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('download-documents-list')) {
            return deny();
        }
        return view('downloads.download_files');
    }
}
