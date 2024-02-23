<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityLogListRequest;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function __invoke(ActivityLogListRequest $request)
    {
        $sortBy = $request->validated('sortBy') ?? 'id';
        $orderBy = $request->validated('orderBy') ?? 'desc';

        return view('activity-log', [
            'activities' => Activity::query()
                ->orderBy($sortBy, $orderBy)
                ->paginate(15),
        ]);
    }
}
