<?php

namespace Modules\Profile\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Traits\ActivityLog;
use App\Traits\HttpResponse;
use Auth;
use Illuminate\Http\JsonResponse;
use Modules\Profile\Http\Resources\NotificationResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use Modules\Profile\Http\Requests\Profile\UserNotificationRequest;
use Modules\Profile\Http\Requests\Profile\UpdateProfileNotificationRequest;

class ProfileNotificationController extends Controller
{
    use HttpResponse;
    use ActivityLog;

    public function show(UserNotificationRequest $request): AnonymousResourceCollection
    {
        $user = Auth::user();
        $notificationsQuery = $user->notifications()->orderByDesc('created_at');
        $status = $request->validated('status');
        $perPage = $request->validated('perPage', config('constants.pagination.default_per_page'));
        if ($status) {
            $method = $status === 'read' ? 'whereNotNull' : 'whereNull';
            $notificationsQuery->$method('read_at');
        }
        $notifications = NotificationResource::collection($notificationsQuery->paginate($perPage));
        $unreadCount = $user->notifications->whereNull('read_at')->count();
        $notifications->additional(['unread_count' => $unreadCount]);
        return $notifications;
    }

    public function update(UpdateProfileNotificationRequest $request): JsonResponse
    {
        $user = Auth::user();
        $notificationId = $request->validated('id');
        $notificationsQuery = $user->notifications()->whereNull('read_at');
        if ($notificationId) {
            $notificationsQuery->whereKey($notificationId);
        }
        $notifications = $notificationsQuery->get();
        if ($notifications->isEmpty()) {
            return $this->response(
                [],
                __('messages.profile.image.notification.update_fail'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        $notificationsQuery->update(['read_at' => now()]);
        return $this->response(
            ['ids' => $notifications->pluck('id')],
            __('messages.profile.image.notification.update_success')
        );
    }
}
