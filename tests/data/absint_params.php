<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use stdClass;
use function absint;

absint(Faker::scalar()); // correct
absint(Faker::array()); // correct
absint(null); // correct
absint('constantString'); // correct

absint(Faker::object()); // incorrect
absint(new stdClass()); // incorrect
