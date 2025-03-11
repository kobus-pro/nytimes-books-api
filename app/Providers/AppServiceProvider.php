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
            $baseUrl = (string) config('services.nytimesbooks.base_url');
            $apiKey = (string) config('services.nytimesbooks.api_key');
                
            return match ($version) {
                'v3' => new NYTimesBooksApiV3Service(
                    baseUrl: $baseUrl,
                    apiKey: $apiKey
                ),
                default => new NYTimesBooksApiV3Service(
                    baseUrl: $baseUrl,
                    apiKey: $apiKey
                ),
            };
        });
    }

    public function boot(): void
    {
        //
    }
}
