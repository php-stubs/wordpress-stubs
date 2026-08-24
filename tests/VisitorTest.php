<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserFactory;
use PhpStubs\WordPress\Core\Visitor;
use PHPUnit\Framework\TestCase;
use StubsGenerator\Result;
use StubsGenerator\StubsGenerator;

final class VisitorTest extends TestCase
{
    /**
     * Generates stub output for a snippet of PHP source using the WordPress stubs Visitor.
     *
     * Symbols are only emitted if they are not already declared, so snippets must use
     * function names that do not exist in the generated `wordpress-stubs.php` (which the
     * PHPStan-based tests load into the process).
     */
    private static function generateStubs(string $code): string
    {
        $parser = (new ParserFactory())->createForNewestSupportedVersion();

        $visitor = new Visitor();
        $visitor->init(StubsGenerator::ALL);

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new NameResolver());
        $traverser->addVisitor($visitor);

        $stmts = $parser->parse($code);
        self::assertNotNull($stmts);
        $traverser->traverse($stmts);

        return (new Result($visitor, []))->prettyPrint();
    }

    /**
     * An existing `@phpstan-return` in the source docblock must be preserved as the only instance.
     */
    public function testHandWrittenPhpStanReturnIsNotDuplicated(): void
    {
        $code = <<<'PHP'
        <?php
        /**
         * @return array|null {
         *     @type string $name Name.
         *     @type string $type Type.
         * }
         * @phpstan-return ?array{name: non-empty-string, type: non-empty-string}
         */
        function wpstubs_test_connector_with_phpstan_return( string $id ): ?array {
            return null;
        }
        PHP;

        $stubs = self::generateStubs($code);

        self::assertSame(1, substr_count($stubs, '@phpstan-return'), $stubs);
        self::assertStringContainsString(
            '@phpstan-return ?array{name: non-empty-string, type: non-empty-string}',
            $stubs
        );
    }

    /**
     * Without an existing `@phpstan-return`, the visitor still synthesises one from
     * a `@return` tag that uses array hash notation.
     */
    public function testPhpStanReturnIsStillGeneratedFromReturnHash(): void
    {
        $code = <<<'PHP'
        <?php
        /**
         * @return array|null {
         *     @type string $name Name.
         *     @type string $type Type.
         * }
         */
        function wpstubs_test_connector_without_phpstan_return( string $id ): ?array {
            return null;
        }
        PHP;

        $stubs = self::generateStubs($code);

        self::assertSame(1, substr_count($stubs, '@phpstan-return'), $stubs);
        self::assertStringContainsString('name: string', $stubs);
        self::assertStringContainsString('type: string', $stubs);
    }
}
