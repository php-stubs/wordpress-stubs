<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use Custom_Background;

$compatibleCallback = static function (): void {
    // Do nothing
};
$incompatibleCallback = static function (int $arg): int {
    return $arg;
};

// Correct
new Custom_Background('', ''); // Empty string as callback is allowed

// Incorrect
new Custom_Background($compatibleCallback, $incompatibleCallback);
