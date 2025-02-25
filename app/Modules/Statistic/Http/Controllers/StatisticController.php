<?php

namespace App\Modules\Statistic\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CustomResponse;
use App\Http\Controllers\Controller;
use App\Modules\Statistic\Services\StatisticService;

class StatisticController extends Controller
{
    use CustomResponse;
    protected $statisticService;

    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }
    public function import(Request $request)
    {
        return $this->statisticService->import($request);
    }
}
