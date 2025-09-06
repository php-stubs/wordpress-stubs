<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function build_dropdown_script_block_core_categories;
use function render_block_core_categories;
use function PHPStan\Testing\assertType;

assertType('non-falsy-string', render_block_core_categories(Faker::array(), Faker::string(), Faker::wpBlock()));

assertType('non-falsy-string', build_dropdown_script_block_core_categories(Faker::string()));
