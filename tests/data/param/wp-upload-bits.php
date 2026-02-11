<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_upload_bits;

// Incorrect
wp_upload_bits('', null, Faker::string());

// Maybe incorrect
wp_upload_bits(Faker::string(), null, Faker::string());

// Correct
wp_upload_bits('foo', null, Faker::string());
wp_upload_bits(Faker::nonEmptyString(), null, Faker::string());
wp_upload_bits(Faker::nonFalsyString(), null, Faker::string());
