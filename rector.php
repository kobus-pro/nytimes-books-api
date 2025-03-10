<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/tests',
    ])->withPhpSets(
        php82: true,
    )->withImportNames()
    ->withParallel(
        timeoutSeconds: 240,
    );
