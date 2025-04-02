<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CsvProcessorService
{
    public function processCsv($file, $userId)
    {
        $data = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_map('trim', array_shift($data));

        foreach ($data as $row) {
            $rowData = array_combine($header, $row);

            $validator = Validator::make($rowData, [
                'date' => 'required|date',
                'steps' => 'required|integer',
                'distance_km' => 'required|numeric',
                'active_minutes' => 'required|integer',
            ]);

            if ($validator->fails()) {
                Log::warning('Invalid CSV row: ', $validator->errors()->toArray());
                continue;
            }

            ActivityLog::updateOrCreate(
                ['user_id' => $userId, 'date' => $rowData['date']],
                [
                    'steps' => $rowData['steps'],
                    'distance_km' => $rowData['distance_km'],
                    'active_minutes' => $rowData['active_minutes'],
                ]
            );
        }
    }
}
