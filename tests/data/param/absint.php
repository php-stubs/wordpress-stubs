<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use stdClass;
use function absint;

$result = absint(Faker::scalar()); // correct
$result = absint(Faker::array()); // correct
$result = absint(null); // correct
$result = absint('constantString'); // correct

$result = absint(Faker::object()); // incorrect
$result = absint(new stdClass()); // incorrect
