<?php

declare(strict_types=1);

use Atoolo\Resource\Test\TestResourceFactory;

return TestResourceFactory::create([
    'url' => '/a.php',
    'id' => 'a',
    'name' => 'a',
    'locale' => 'en_US',
    'base' => [
        'trees' => [
            'category' => [
                'children' => [
                    'b' => [
                        'id' => 'b',
                        'url' => '/b.php',
                    ],
                ],
            ],
        ],
    ],
]);
