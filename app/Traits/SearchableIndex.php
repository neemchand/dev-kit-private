<?php

namespace App\Traits;

use App\Services\SearchService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Throwable;

trait SearchableIndex
{
    private readonly string $searchClass;
    private readonly string $searchResourceClass;

    private function searchIndex(Request $request, SearchService $service, Builder $builder = null): AnonymousResourceCollection|JsonResponse
    {
        $sortBy = $request->validated('sortBy');
        $orderBy = $request->validated('orderBy');
        $perPage = $request->validated('perPage', config('constants.pagination.default_per_page'));
        $search = $request->validated('search');

        try {
            $builder = $builder ?? $service->search($this->searchClass, $search);
            if ($sortBy && $orderBy) {
                $builder->orderBy($sortBy, $orderBy);
            }
            return ($this->searchResourceClass)::collection(
                $builder->paginate($perPage)->withQueryString()
            );
        } catch (Throwable $throwable) {
            $this->activity(
                __('messages.user.search_error'),
                Auth::user(),
                null,
                ['message' => $throwable->getMessage(), 'trace' => $throwable->getTraceAsString()]
            );
            return $this->response([], __('messages.user.search_error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
