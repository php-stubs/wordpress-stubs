<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use Custom_Image_Header;

$compatibleCallback = static function (): void {
    // Do nothing
};
$incompatibleCallback = static function (int $arg): int {
    return $arg;
};

// Correct
new Custom_Image_Header($compatibleCallback, ''); // Empty string as callback is allowed

// Incorrect
new Custom_Image_Header($compatibleCallback, $incompatibleCallback);
