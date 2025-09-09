<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function antispambot;

$email = Faker::string();

// Incorrect $hex_encoding
antispambot($email, 42);
antispambot($email, -42);
antispambot($email, Faker::string());

// Maybe incorrect $hex_encoding
antispambot($email, Faker::int());

// Correct $hex_encoding
antispambot($email, 0);
antispambot($email, 1);
