<?php

declare(strict_types=1);

namespace App\Data\NYTimes;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class RanksHistoryData extends Data
{
    public function __construct(
        #[MapInputName('primary_isbn10')]
        public string $primaryIsbn10,
        
        #[MapInputName('primary_isbn13')]
        public string $primaryIsbn13,
        
        public int $rank,
        
        #[MapInputName('list_name')]
        public string $listName,
        
        #[MapInputName('display_name')]
        public string $displayName,
        
        #[MapInputName('published_date')]
        public string $publishedDate,
        
        #[MapInputName('bestsellers_date')]
        public string $bestsellersDate,
        
        #[MapInputName('weeks_on_list')]
        public int $weeksOnList,
        
        #[MapInputName('rank_last_week')]
        public int $rankLastWeek,
        
        public int $asterisk,
        
        public int $dagger
    ) {
    }
}