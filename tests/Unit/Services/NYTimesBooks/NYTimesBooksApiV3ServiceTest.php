<?php

declare(strict_types=1);

namespace Tests\Unit\Services\NYTimesBooks;

use App\Exceptions\NYTimesBooks\ApiAuthenticationException;
use App\Exceptions\NYTimesBooks\ApiNotFoundException;
use App\Exceptions\NYTimesBooks\ApiRateLimitException;
use App\Services\NYTimesBooks\NYTimesBooksApiV3Service;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use ReflectionClass;
use Tests\TestCase;

class NYTimesBooksApiV3ServiceTest extends TestCase
{
    protected NYTimesBooksApiV3Service $service;
    protected $apiBaseUrl = 'https://api.nytimes.com';
    protected $apiKey = 'test-api-key';
    protected string $bestSellersHistoryPath;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('services.nytimesbooks.base_url', $this->apiBaseUrl);
        config()->set('services.nytimesbooks.api_key', $this->apiKey);

        $this->service = new NYTimesBooksApiV3Service();

        $reflector = new ReflectionClass(NYTimesBooksApiV3Service::class);
        $this->bestSellersHistoryPath = $reflector->getConstant('BEST_SELLERS_HISTORY_PATH');
    }

    #[Test]
    public function getBestSellerHistoryThrows401Exception(): void
    {
        Http::fake([
            "{$this->apiBaseUrl}{$this->bestSellersHistoryPath}*" => Http::response([
                'fault' => [
                    'faultstring' => 'Invalid API Key',
                    'detail' => [
                        'errorcode' => 'oauth.v2.InvalidApiKey'
                    ]
                ]
            ], HttpResponse::HTTP_UNAUTHORIZED)
        ]);

        $this->expectException(ApiAuthenticationException::class);
        $this->expectExceptionCode(HttpResponse::HTTP_UNAUTHORIZED);

        $this->service->getBestSellerHistory(['author' => 'Test Author']);
    }

    #[Test]
    public function getBestSellerHistoryThrows404Exception(): void
    {
        Http::fake([
            "{$this->apiBaseUrl}{$this->bestSellersHistoryPath}*" => Http::response([
                'fault' => [
                    'faultstring' => 'Unable to identify proxy for host: api_secure and url: ' . $this->bestSellersHistoryPath,
                    'detail' => [
                        'errorcode' => 'messaging.adaptors.http.flow.ApplicationNotFound'
                    ]
                ]
            ], HttpResponse::HTTP_NOT_FOUND)
        ]);

        $this->expectException(ApiNotFoundException::class);
        $this->expectExceptionCode(HttpResponse::HTTP_NOT_FOUND);

        try {
            $this->service->getBestSellerHistory(['author' => 'Test Author']);
        } catch (ApiNotFoundException $e) {
            $this->assertEquals($this->bestSellersHistoryPath, $e->getResource());
            $this->assertEquals('messaging.adaptors.http.flow.ApplicationNotFound', $e->getErrorCode());
            throw $e;
        }
    }

    #[Test]
    public function getBestSellerHistoryThrows429Exception(): void
    {
        Http::fake([
            "{$this->apiBaseUrl}{$this->bestSellersHistoryPath}*" => Http::response([
                'fault' => [
                    'faultstring' => 'Rate limit exceeded',
                    'detail' => [
                        'errorcode' => 'messaging.adaptors.http.flow.ThrottleExceeded'
                    ]
                ]
            ], HttpResponse::HTTP_TOO_MANY_REQUESTS, [
                'Retry-After' => '60'
            ])
        ]);

        $this->expectException(ApiRateLimitException::class);
        $this->expectExceptionCode(HttpResponse::HTTP_TOO_MANY_REQUESTS);

        try {
            $this->service->getBestSellerHistory(['author' => 'Test Author']);
        } catch (ApiRateLimitException $e) {
            throw $e;
        }
    }    
}
