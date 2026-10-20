<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use WP_Image_Editor;

use function PHPStan\Testing\assertType;

abstract class ImageEditor extends WP_Image_Editor // phpcs:ignore Squiz.Classes.ClassFileName.NoMatch
{
    public function test(): void
    {
        assertType('array{string|null, string|false, string}', $this->get_output_format());
        assertType('array{string|null, string|false, string}', $this->get_output_format('image.jpg', 'image/webp'));
    }
}
