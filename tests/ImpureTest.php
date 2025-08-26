<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

final class ImpureTest extends TypeInferenceTest
{
    public function dataAsserts(): iterable
    {
        yield from $this->gatherAssertTypes(__DIR__ . '/data/impure/get_password_reset_key.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/impure/have_posts.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/impure/taxonomy_exists.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/impure/wp_generate_password.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/impure/wp_generate_uuid4.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/impure/wp_nonce_tick.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/impure/wp_rand.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/impure/wp_unique_id.php');
        yield from $this->gatherAssertTypes(__DIR__ . '/data/impure/wp_unique_prefixed_id.php');
    }
}
