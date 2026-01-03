<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Reviews;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public const PAGE_KEY = 'Review';
    public const MSG_CREATE_SUCCESS = Messages::MSG_CREATE_SUCCESS;
    public const MSG_LIST_SUCCESS = Messages::MSG_LIST_SUCCESS;
    public const MSG_UPDATE_SUCCESS = Messages::MSG_UPDATE_SUCCESS;
    public const MSG_DELETE_SUCCESS = Messages::MSG_DELETE_SUCCESS;
    public const VIEW_NAMESPACE = 'admin.catalog.reviews';
    public function __construct(AppUtils $appUtils, Reviews $reviews)
    {
        parent::__construct($appUtils, $reviews);
    }

    public function index()
    {
        return parent::executeWithTryCatch(function (): View {
            $reviews = $this->getAllResources();
            return $this->successView(self::VIEW_NAMESPACE, ['reviews' => $reviews]);
        });
    }

    public function store(ReviewRequest $request): RedirectResponse|View
    {
        $data = $this->prepareData($request);
        return parent::handleOperation(function () use ($data) {
            $this->createResource($data);
        }, self::MSG_CREATE_SUCCESS);
    }

    public function update(ReviewRequest $request, int $review): RedirectResponse|View
    {
        $data = $this->prepareData($request);
        return parent::handleOperation(function () use ($review, $data) {
            $this->updateResource($review, $data);
        }, self::MSG_UPDATE_SUCCESS);
    }

    public function destroy(int $review): RedirectResponse|View
    {
        return parent::handleOperation(function () use ($review) {
            $this->deleteResource($review);
        }, self::MSG_DELETE_SUCCESS);
    }

    public function edit(int $review)
    {
        return parent::executeWithTryCatch(function () use ($review): JsonResponse {
            $reviewData = $this->findOrRedirect($review);
            return $this->apiSuccessResponse(self::MSG_LIST_SUCCESS, ['review' => $reviewData]);
        });
    }

    private function prepareData(ReviewRequest $request): array
    {
        $validatedData = $request->validated();
        return [
            'product_id' => $validatedData['product_id'],
            'customer_id' => $validatedData['customer_id'],
            'rating' => $validatedData['rating'],
            'comment' => $validatedData['comment'] ?? null,
            'is_approved' => $validatedData['is_approved'] ?? 0,
        ];
    }

}