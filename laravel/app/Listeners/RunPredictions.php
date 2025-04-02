<?php

namespace App\Listeners;

use App\Events\CsvUpdated;
use App\Services\PredictionService;

class UpdatePredictions
{
    protected $predictionService;

    public function __construct(PredictionService $predictionService)
    {
        $this->predictionService = $predictionService;
    }

    public function handle(CsvUpdated $event)
    {
        $this->predictionService->runPredictions($event->userId);
    }
}
