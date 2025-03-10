<?php

declare(strict_types=1);

namespace App\Data\NYTimes;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;

class BookResultData extends Data
{
    public function __construct(
        public string $title,
        public ?string $description,
        public ?string $contributor,
        public string $author,
        #[MapInputName('contributor_note')]
        public ?string $contributorNote,
        public ?string $price,
        #[MapInputName('age_group')]
        public ?string $ageGroup,
        public ?string $publisher,
        #[DataCollectionOf(BookIsbnData::class)]
        public array $isbns,
        #[MapInputName('ranks_history')]
        #[DataCollectionOf(RanksHistoryData::class)]
        public array $ranksHistory,
        #[DataCollectionOf(BookReviewData::class)]
        public array $reviews,
    ) {}
}
