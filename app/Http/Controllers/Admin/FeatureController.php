<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NotificationEnum;
use App\Http\Controllers\Controller;
use App\ValueObjects\Admin\NotificationVO;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Laravel\Pennant\Feature;

class FeatureController extends Controller
{
    public function index(): View
    {
        return view('features.list', [
            'features' => Feature::for('__global')->all()
        ]);
    }

    public function toggle(Request $request)
    {
        if (!$request->has('featureName') || !in_array($request->featureName, Feature::defined())) {
            return Redirect::route('admin.features.index');
        }

        $active = Feature::for('__global')->active($request->featureName);
        $method = ($active ? 'de' : '') . 'activateForEveryone';
        call_user_func([Feature::class, $method], $request->featureName);

        return Redirect::route('admin.features.index');
    }

    public function create(): View
    {
        return view('features.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if (!$request->has('featureName') || empty(trim($request->featureName))) {
            return Redirect::route('admin.features.create')->with(
                'notification',
                new NotificationVO(
                    NotificationEnum::FAIL,
                    __('messages.notification.fail'),
                    __('messages.feature.name_cannot_be_empty')
                )
            );
        }

        if (in_array($request->featureName, Feature::defined())) {
            return Redirect::route('admin.features.create')->with(
                'notification',
                new NotificationVO(
                    NotificationEnum::FAIL,
                    __('messages.notification.fail'),
                    __('messages.feature.name_already_exists')
                )
            );
        }

        Feature::define($request->featureName, (bool)$request->active);
        Feature::for('__global')->active($request->featureName); // resolve once to save in DB
        return Redirect::route('admin.features.index');
    }

    public function destroy(Request $request): RedirectResponse
    {
        if (!$request->has('featureName') || !in_array($request->featureName, Feature::defined())) {
            return Redirect::route('admin.features.index');
        }

        DB::delete('DELETE FROM features WHERE name=?', [$request->featureName]);

        return Redirect::route('admin.features.index');
    }
}
