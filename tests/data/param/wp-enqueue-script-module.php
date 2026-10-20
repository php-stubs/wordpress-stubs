<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function wp_enqueue_script_module;

// Incorrect usage
wp_enqueue_script_module('id', '', [], false, ['in_footer' => 'yes']); // incorrect
wp_enqueue_script_module('id', '', [], false, ['fetchpriority' => 'urgent']); // incorrect
wp_enqueue_script_module('id', '', [], false, ['other' => 1]); // incorrect
wp_enqueue_script_module('id', '', [], false, [1 => true]); // incorrect

// Correct usage
wp_enqueue_script_module('id');
wp_enqueue_script_module('id', '', [], false, []);
wp_enqueue_script_module('id', '', [], false, ['in_footer' => true, 'fetchpriority' => 'low']);
wp_enqueue_script_module('id', '', [], false, ['other' => 'value', 'flag' => false]);
