<?php

declare(strict_types=1);

return [
    'character_set_ranges' => [
        [2, 16, '/^[0-9A-Fa-f]+$/'],
        [32, 36, '/^[0-9A-Za-z]+$/'],
        [58, 62, '/^[0-9A-HJ-NP-Za-km-z1-9]+$/'],
    ],
];
