<?php

namespace Modules\UserInvitation\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Modules\UserInvitation\Models\UserInvitation;
use Modules\UserInvitation\Http\Requests\UserInvitationDeleteRequest;
use Modules\UserInvitation\Http\Requests\UserInvitationListRequest;
use Modules\UserInvitation\Http\Requests\UserInvitationRequest;
use App\Http\Resources\UserInvitationResource;
use Modules\UserInvitation\Services\SearchService;
use Modules\UserInvitation\Services\UserInvitationService;
use App\Traits\ActivityLog;
use App\Traits\HttpResponse;
use App\Traits\SearchableIndex;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;

class UserInvitationController extends Controller
{
    use ActivityLog;
    use HttpResponse;
    use SearchableIndex;

    public function __construct(
        private readonly string $searchClass = UserInvitation::class,
        private readonly string $searchResourceClass = UserInvitationResource::class
    ) {
    }

    public function index(
        UserInvitationListRequest $request,
        SearchService $service
    ): AnonymousResourceCollection|JsonResponse {
        return $this->searchIndex($request, $service);
    }

    public function store(UserInvitationRequest $request, UserInvitationService $userInvitationService): JsonResponse
    {
        $invitation = $userInvitationService->create($request->safe()->toArray());

        return $this->response(
            [],
            __('messages.invitation.created', [
                'email' => $invitation->email,
                'expiration' => $invitation->expires_at->format('r')
            ])
        );
    }

    public function verify(Request $request): RedirectResponse
    {
        $url = config('app.frontend_url');
        $pathSuccess = config('frontend.invitation_success_redirect');
        $pathFail = config('frontend.invitation_fail_redirect');

        $invitation = UserInvitation::where('signature', $request->signature)
            ->where('expires_at', '>=', now())->first();

        if (is_null($invitation)) {
            return redirect($url . $pathFail);
        }

        $param = Arr::query(['signature' => $invitation->signature]);

        return redirect($url . $pathSuccess . "?$param");
    }

    public function destroy(UserInvitationDeleteRequest $request, UserInvitationService $service): JsonResponse
    {
        $service->invalidate($request->validated()['id']);
        return $this->response([], __('messages.invitation.deleted'));
    }
}
