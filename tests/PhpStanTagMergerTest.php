<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use PhpStubs\WordPress\Core\PhpStanTagMerger;
use PHPUnit\Framework\TestCase;

final class PhpStanTagMergerTest extends TestCase
{
    /**
     * @dataProvider tagOverrides
     */
    public function testOnlyTheMatchingTagIsReplaced(string $existing, string $replacement, string $unrelated): void
    {
        $comment = sprintf("/**\n * Description with `@phpstan-return` in prose.\n *\n * @since 1.0\n * %s\n * %s\n */", $existing, $unrelated);
        $merged = (new PhpStanTagMerger())->merge($comment, [$replacement]);

        self::assertStringNotContainsString(sprintf("\n * %s\n", $existing), $merged);
        self::assertStringContainsString(sprintf("\n * %s\n", $replacement), $merged);
        self::assertStringContainsString(sprintf("\n * %s\n", $unrelated), $merged);
        self::assertStringContainsString("Description with `@phpstan-return` in prose.\n *\n * @since 1.0", $merged);
    }

    /** @return iterable<string, array{string, string, string}> */
    public function tagOverrides(): iterable
    {
        yield 'multiline return' => ["@phpstan-return array{\n *     id: int\n * }", '@phpstan-return array{id: positive-int}', '@return array The result.'];
        yield 'parameter' => ['@phpstan-param int $first', '@phpstan-param positive-int $first', '@phpstan-param string $second'];
        yield 'template' => ['@phpstan-template T of int', '@phpstan-template T of positive-int', '@phpstan-template U of string'];
        yield 'property' => ['@phpstan-property-read int $first', '@phpstan-property-read positive-int $first', '@phpstan-property-read string $second'];
        yield 'method' => ['@phpstan-method int first()', '@phpstan-method positive-int first()', '@phpstan-method string second()'];
        yield 'alias' => ['@phpstan-type First int', '@phpstan-type First positive-int', '@phpstan-type Second string'];
        yield 'import' => ['@phpstan-import-type First from OldClass', '@phpstan-import-type First from NewClass', '@phpstan-import-type Second from OldClass'];
        yield 'interface' => ['@phpstan-implements \ArrayAccess<int, mixed>', '@phpstan-implements ArrayAccess<int, string>', '@phpstan-implements Iterator<int, mixed>'];
        yield 'assertion' => ['@phpstan-assert-if-true int $first', '@phpstan-assert-if-true positive-int $first', '@phpstan-assert-if-true string $second'];
    }
}
