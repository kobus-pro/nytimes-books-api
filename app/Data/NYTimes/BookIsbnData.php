<?php

declare(strict_types=1);

namespace App\Data\NYTimes;

use Spatie\LaravelData\Data;

class BookIsbnData extends Data
{
    public function __construct(
        public ?string $isbn10,
        public ?string $isbn13,
    ) {
    }
}