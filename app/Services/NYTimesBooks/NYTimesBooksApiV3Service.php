<?php

declare(strict_types=1);

namespace App\Services\NYTimesBooks;

use App\Contracts\NYTimesBooksApiInterface;
use App\Exceptions\NYTimesBooks\ApiAuthenticationException;
use App\Exceptions\NYTimesBooks\ApiException;
use App\Exceptions\NYTimesBooks\ApiNotFoundException;
use App\Exceptions\NYTimesBooks\ApiRateLimitException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NYTimesBooksApiV3Service implements NYTimesBooksApiInterface
{
    protected string $baseUrl;
    protected string $apiKey;

    protected const BEST_SELLERS_HISTORY_PATH = '/svc/books/v3/lists/best-sellers/history.json';

    public function __construct()
    {
        $this->baseUrl = config('services.nytimesbooks.base_url');
        $this->apiKey = config('services.nytimesbooks.api_key');
    }

    public function getBestSellerHistory(array $params = [])
    {
        $url = $this->baseUrl . self::BEST_SELLERS_HISTORY_PATH;

        try {
            $response = Http::get($url, array_merge($params, ['api-key' => $this->apiKey]));

            $this->handleApiErrors($response);

            return $response->json();
        } catch (ApiAuthenticationException | ApiRateLimitException | ApiNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('NY Times Books API error: ' . $e->getMessage());
            throw new ApiException(
                message: 'An error occurred while communicating with the NY Times Books API.',
                statusCode: $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Handle API error responses based on status codes
     *
     * @param Response $response
     * @throws ApiAuthenticationException
     * @throws ApiRateLimitException
     * @throws ApiNotFoundException
     * @throws ApiException
     */
    protected function handleApiErrors(Response $response): void
    {
        if ($response->successful()) {
            return;
        }

        $statusCode = $response->status();
        $responseData = $response->json() ?: null;
        $errorMessage = $responseData['fault']['detail'] ?? ($responseData['message'] ?? 'Unknown error');

        switch ($statusCode) {
            case 401:
                throw new ApiAuthenticationException(
                    message: 'Authentication failed. Please check your NY Times Books API key!',
                    statusCode: $statusCode,
                    responseData: $responseData
                );
            case 403:
                throw new ApiRateLimitException(
                    message: 'API rate limit exceeded or forbidden request.',
                    statusCode: $statusCode,
                    responseData: $responseData
                );
            case 404:
                $resource = null;
                if (isset($responseData['fault']['faultstring'])) {
                    $faultString = $responseData['fault']['faultstring'];
                    if (preg_match('/url:\s+(.+?)(?:\s|$)/', $faultString, $matches)) {
                        $resource = trim($matches[1]);
                    }
                }

                throw new ApiNotFoundException(
                    message: 'The requested resource was not found.',
                    resource: $resource,
                    statusCode: $statusCode,
                    responseData: $responseData
                );
            case 429:
                throw new ApiRateLimitException(
                    message: 'API rate limit exceeded. Please try again later.',
                    statusCode: $statusCode,
                    responseData: $responseData
                );
            default:
                throw new ApiException(
                    message: "NY Times Books API error ({$statusCode}): {$errorMessage}",
                    statusCode: $statusCode,
                    responseData: $responseData
                );
        }
    }
}