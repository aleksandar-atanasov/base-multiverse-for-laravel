<?php

declare(strict_types=1);

return [
    'character_set_ranges' => [
        [2, 16, '/^[0-9A-Fa-f]+$/'],
        [32, 36, '/^[0-9A-Za-z]+$/'],
        [58, 59, '/^[0-9A-HJ-NP-Za-km-z]+$/'],
        [60, 62, '/^[0-9A-Za-z_-]{7}$/'], // 7 chars
    ],
];
