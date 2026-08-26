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
     * The `@phpstan-var` tag of the stubs, up to the end of its shape.
     */
    private static function phpStanVarTag(string $stubs): string
    {
        $position = strpos($stubs, '@phpstan-var');
        self::assertIsInt($position, $stubs);

        $tag = strstr(substr($stubs, $position), '}', true);
        self::assertIsString($tag, $stubs);

        return $tag;
    }

    /**
     * A function documenting the shape of the object it returns, for the property tests below.
     */
    private const REFERENCED_FUNCTION = <<<'PHP'
        <?php
        /**
         * Builds the labels.
         *
         * @return object {
         *     Labels object.
         *
         *     @type string      $name   General name.
         *     @type string|null $parent Only set for hierarchical things.
         * }
         */
        function wpstubs_test_build_labels($thing) { return (object) array(); }
        PHP;

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

    /**
     * A property pointing at the function that builds its value takes that shape.
     */
    public function testPhpStanVarIsInheritedFromReferencedFunction(): void
    {
        $code = self::REFERENCED_FUNCTION . <<<'PHP'
        class WPStubs_Test_Labelled {
            /**
             * Labels object for this thing.
             *
             * @see wpstubs_test_build_labels()
             *
             * @var stdClass
             */
            public $labels;
        }
        PHP;

        $stubs = self::generateStubs($code);

        $varTag = self::phpStanVarTag($stubs);

        self::assertStringContainsString('@phpstan-var object{', $varTag);
        self::assertStringContainsString('name: string', $varTag);
        self::assertStringContainsString('parent: string|null', $varTag);
    }

    /**
     * The referenced shape has to fit the type the property is declared as.
     */
    public function testPhpStanVarIsNotInheritedForAMismatchingType(): void
    {
        $code = self::REFERENCED_FUNCTION . <<<'PHP'
        class WPStubs_Test_Mismatched {
            /**
             * An array cannot take the shape of a returned object.
             *
             * @see wpstubs_test_build_labels()
             *
             * @var array
             */
            public $labels = array();
        }
        PHP;

        $stubs = self::generateStubs($code);

        self::assertStringNotContainsString('@phpstan-var', $stubs);
    }

    /**
     * A property that documents its own shape keeps it.
     */
    public function testPhpStanVarOfThePropertyWins(): void
    {
        $code = self::REFERENCED_FUNCTION . <<<'PHP'
        class WPStubs_Test_Own_Shape {
            /**
             * Its own shape wins over the referenced one.
             *
             * @see wpstubs_test_build_labels()
             *
             * @var stdClass {
             *     Own shape.
             *
             *     @type string $own Own key.
             * }
             */
            public $labels;
        }
        PHP;

        $stubs = self::generateStubs($code);

        $varTag = self::phpStanVarTag($stubs);

        self::assertSame(1, substr_count($stubs, '@phpstan-var'), $stubs);
        self::assertStringContainsString('own: string', $varTag);
        self::assertStringNotContainsString('parent: string|null', $varTag);
    }

    /**
     * A property with no reference is left alone.
     */
    public function testPhpStanVarIsNotInheritedWithoutAReference(): void
    {
        $code = self::REFERENCED_FUNCTION . <<<'PHP'
        class WPStubs_Test_Unreferenced {
            /**
             * No reference at all.
             *
             * @var stdClass
             */
            public $labels;
        }
        PHP;

        $stubs = self::generateStubs($code);

        self::assertStringNotContainsString('@phpstan-var', $stubs);
    }
}
