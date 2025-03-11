<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\NYTimesBooksApiInterface;
use App\Services\NYTimesBooks\NYTimesBooksApiV3Service;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(NYTimesBooksApiInterface::class, function () {
            $version = config('services.nytimesbooks.version', 'v3');
            
            return match ($version) {
                'v3' => new NYTimesBooksApiV3Service(),
                default => new NYTimesBooksApiV3Service(),
            };
        });
    }

    public function boot(): void
    {
        //
    }
}
