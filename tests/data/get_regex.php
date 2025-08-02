<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function get_shortcode_regex;
use function get_shortcode_atts_regex;
use function get_tag_regex;
use function PHPStan\Testing\assertType;

assertType('non-falsy-string', get_shortcode_regex());
assertType('non-falsy-string', get_shortcode_regex(Faker::array()));

assertType('non-falsy-string', get_shortcode_atts_regex());

assertType('non-falsy-string', get_tag_regex(Faker::string()));
