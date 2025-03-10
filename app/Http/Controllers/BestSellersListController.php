<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\NYTimesBooksApiInterface;
use App\Data\NYTimes\NYTimesResponseData;
use App\Http\Requests\BestSellersListRequest;
use Illuminate\Http\JsonResponse;

class BestSellersListController extends Controller
{
    public function __construct(
        private readonly NYTimesBooksApiInterface $nytimesBooksApi
    ) {}

    public function __invoke(BestSellersListRequest $request): JsonResponse
    {
        $response = $this->nytimesBooksApi->getBestSellerHistory($request->validated());

        $data = NYTimesResponseData::fromApiResponse($response);

        return response()->json($data);
    }
}
