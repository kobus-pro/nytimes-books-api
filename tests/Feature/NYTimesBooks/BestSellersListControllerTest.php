<?php

declare(strict_types=1);

namespace Tests\NYTimesBooks\Feature;

use Generator;
use App\Contracts\NYTimesBooksApiInterface;
use Illuminate\Http\Response as HttpResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\Doubles\Stubs\NYTimesBooks\GetBestSellerHistoryResponse;
use Tests\TestCase;

class BestSellersListControllerTest extends TestCase
{
    use MatchesSnapshots;

    private string $url;

    public function setUp(): void
    {
        parent::setUp();
        $this->url = route('api.books.best-sellers');
    }

    #[DataProvider('responseProvider')]
    #[Test]
    public function endpointReturnsCorrectStructureApiResponse(array $mockedResponse): void
    {
        $this->mock(NYTimesBooksApiInterface::class, function ($mock) use ($mockedResponse) {
            $mock->shouldReceive('getBestSellerHistory')
                ->once()
                ->andReturn($mockedResponse);
        });

        $response = $this->getJson($this->url);

        $response->assertStatus(HttpResponse::HTTP_OK);
        $response->assertJsonStructure([
            'status',
            'copyright',
            'count',
            'items',
        ]);
        $this->assertMatchesJsonSnapshot($response->json());
    }

    #[Test]
    public function endpointPassesRequestParamsToApi(): void
    {
        $requestParams = [
            'author' => 'Diana Gabaldon',
            'isbns' => ['0807006483', '9780807006474'],
            'title' => 'Outlander',
        ];
    
        $expectedApiParams = [
            'author' => 'Diana Gabaldon',
            'title' => 'Outlander',
            'isbn' => '0807006483;9780807006474'
        ];
    
        $this->mock(NYTimesBooksApiInterface::class, function ($mock) use ($expectedApiParams) {
            $mock->shouldReceive('getBestSellerHistory')
                ->once()
                ->with($expectedApiParams)
                ->andReturn(GetBestSellerHistoryResponse::EMPTY_RESPONSE);
        });
    
        $url = sprintf('%s?%s', $this->url, http_build_query($requestParams));
    
        $response = $this->getJson($url);
    
        $response->assertStatus(HttpResponse::HTTP_OK);
    }

    #[Test]
    public function endpointHandlesInvalidOffsetParam(): void
    {
        $url = sprintf('%s?%s', $this->url, 'offset=15');

        $response = $this->getJson($url);

        $response->assertStatus(HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['offset']);
    }

    #[Test]
    public function endpointValidatesOffsetIsMultipleOf20(): void
    {
        $this->mock(NYTimesBooksApiInterface::class, function ($mock) {
            $mock->shouldReceive('getBestSellerHistory')
                ->once()
                ->andReturn(GetBestSellerHistoryResponse::EMPTY_RESPONSE);
        });

        $url = sprintf('%s?%s', $this->url, 'offset=40');
        $response = $this->getJson($url);

        $response->assertStatus(HttpResponse::HTTP_OK);
    }

    public static function responseProvider(): Generator
    {
        yield 'empty' => [
            GetBestSellerHistoryResponse::EMPTY_RESPONSE,
        ];
        yield 'single' => [
            GetBestSellerHistoryResponse::SINGLE_RESULT_RESPONSE,
        ];
        yield 'multiple' => [
            GetBestSellerHistoryResponse::MULTIPLE_RESULTS_RESPONSE,
        ];
    }
}
