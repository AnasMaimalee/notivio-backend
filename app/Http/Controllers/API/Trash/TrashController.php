<?php

namespace App\Http\Controllers\API\Trash;

use App\Http\Controllers\Controller;
use App\Services\TrashService;

class TrashController extends Controller
{
    public function __construct(protected TrashService $service) {}

    public function index()
    {
        $user = auth('api')->user();

        $trash = $this->service->fetchTrash($user);

        return response()->json($trash);
    }
}
