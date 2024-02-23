<?php

namespace Modules\Profile\Http\Controllers\v1;

use App\Traits\HttpResponse;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Profile\Http\Resources\UserResource;
use Modules\Profile\Http\Requests\Profile\UpdateProfileRequest;

class ProfileController extends Controller
{
    use HttpResponse;

    public function show(): JsonResponse
    {
        $user = Auth::user();

        return $this->resourceResponse(new UserResource($user));
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        $user->fill($request->validated());
        $message = __('messages.profile.updated');

        if ($user->isDirty('email')) {
            $service = new UserService();
            $service->emailReVerification($user);
            $service->expireTokens($user);
            $message = __('messages.profile.updated_with_email');
        }
        $user->save();

        return $this->resourceResponse(
            new UserResource($request->user()),
            $message
        );
    }

    public function destroy(): JsonResponse
    {
        $user = Auth::user();
        $user->delete();

        return $this->response([], __('messages.profile.deleted'));
    }
}
