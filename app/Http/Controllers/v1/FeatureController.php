<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Laravel\Pennant\Feature;

class FeatureController extends Controller
{
    public function index(): JsonResponse
    {
        return new JsonResponse(Feature::all());
    }
}
