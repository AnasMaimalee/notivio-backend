<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Jotting;
use App\Models\JottingVersion;
use App\Services\JottingVersionService;

class JottingVersionController extends Controller
{
    public function __construct(
        protected JottingVersionService $service
    ) {}

    public function index(Jotting $jotting)
    {
        return response()->json(
            $this->service->history($jotting)
        );
    }

    public function restore(Jotting $jotting, JottingVersion $version)
    {
        return response()->json(
            $this->service->restore($jotting, $version)
        );
    }
}
