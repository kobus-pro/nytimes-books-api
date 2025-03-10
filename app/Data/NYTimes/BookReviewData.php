<?php

declare(strict_types=1);

namespace App\Data\NYTimes;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class BookReviewData extends Data
{
    public function __construct(
        #[MapInputName('book_review_link')]
        public ?string $bookReviewLink,
        #[MapInputName('first_chapter_link')]
        public ?string $firstChapterLink,
        #[MapInputName('article_chapter_link')]
        public ?string $articleChapterLink,
        #[MapInputName('sunday_review_link')]
        public ?string $sundayReviewLink = '',
    ) {}
}
