<?php

declare(strict_types=1);

namespace App\Data\NYTimes;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class NYTimesResponseData extends Data
{
    public function __construct(
        public string $status,
        public string $copyright,
        public int $count,
        #[DataCollectionOf(BookResultData::class)]
        public array $items
    ) {
    }
    
    public static function fromApiResponse(array $response): self
    {
        return new self(
            status: $response['status'],
            copyright: $response['copyright'],
            count: $response['num_results'],
            items: array_map(fn ($item) => BookResultData::from($item), $response['results'])
        );
    }
}