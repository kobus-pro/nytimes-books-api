<?php

declare(strict_types=1);

namespace App\Contracts;

interface NYTimesBooksApiInterface
{
    public function getBestSellerHistory(array $params = []);
}
