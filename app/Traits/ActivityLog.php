<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ActivityLog
{
    public function activity(
        string $log,
        Model|int|string|null $causer = null,
        Model|null $subject = null,
        array|Collection $properties = []
    ): void {
        $activity = activity()
            ->causedBy($causer)
            ->withProperties($properties);
        if ($subject) {
            $activity->performedOn($subject);
        }
        $activity->log($log);
    }
}
