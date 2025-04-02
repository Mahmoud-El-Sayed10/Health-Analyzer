<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CsvProcessorService;
use App\Events\CsvUpdated;

class ActivityLogController extends Controller
{
    protected CsvProcessorService $csvService;

    public function __construct(CsvProcessorService $csvService)
    {
        $this->csvService = $csvService;

        $this->middleware('auth:api');
    }

    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $this->csvService->processCsv($request->file('csv_file'), $request->user()->id);

        event(new CsvUpdated($request->user()->id));

        return response()->json(['message' => 'CSV uploaded and processed.']);
    }
}
