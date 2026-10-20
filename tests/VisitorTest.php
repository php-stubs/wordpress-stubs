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
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testMapReturnDoesNotOverrideExistingReturn(): void
    {
        $code = <<<'PHP'
        <?php
        /**
         * @phpstan-return int|false
         */
        function check_admin_referer($action = -1) {}
        /**
         * @return int|false
         */
        function check_ajax_referer($action = -1, $query_arg = false, $stop = true) {}
        PHP;

        $stubs = self::generateStubs($code);

        self::assertSame(2, substr_count($stubs, '@phpstan-return'), $stubs);
        self::assertStringContainsString('@phpstan-return int|false', $stubs);
        self::assertStringNotContainsString('@phpstan-return ($action is', $stubs);
        self::assertStringContainsString('@phpstan-param string $action', $stubs);
        self::assertStringContainsString('@phpstan-return ($stop is true ? 1|2 : 1|2|false)', $stubs);
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
     * Args inherited from a `@see`d symbol must not duplicate the keys which
     * are documented on the symbol itself, only missing keys are inherited.
     */
    public function testInheritedArgsDoNotDuplicateDocumentedArgs(): void
    {
        $code = <<<'PHP'
        <?php
        /**
         * @param array $args {
         *     Optional. Arguments.
         *
         *     @type bool $foo Description of foo.
         *     @type int  $bar Description of bar.
         * }
         */
        function donor($args = []) {}
        /**
         * @param array $args {
         *     Optional. Arguments. See donor() for additional arguments.
         *
         *     @type bool $foo Description of foo.
         * }
         */
        function recipient($args = []) {}
        PHP;

        $stubs = self::generateStubs($code);

        [, $listItems] = explode('function donor', $stubs, 2);

        self::assertSame(1, substr_count($listItems, 'foo?: bool'), $listItems);
        self::assertSame(1, substr_count($listItems, 'bar?: int'), $listItems);
    }

    /**
     * Args inherited from a `@see`d symbol must not override the keys which are
     * documented on the symbol itself.
     */
    public function testInheritedArgsDoNotOverrideDocumentedArgs(): void
    {
        $code = <<<'PHP'
        <?php
        /**
         * @param array $args {
         *     Optional. Arguments.
         *
         *     @type int $foo Description of foo.
         * }
         */
        function donor($args = []) {}
        /**
         * @param array $args {
         *     Optional. Arguments. See donor() for additional arguments.
         *
         *     @type bool $foo Description of foo.
         * }
         */
        function recipient($args = []) {}
        PHP;

        $stubs = self::generateStubs($code);

        [, $listItems] = explode('function donor', $stubs, 2);

        self::assertStringContainsString('foo?: bool', $listItems);
        self::assertStringNotContainsString('foo?: int', $listItems);
    }

    /**
     * A shape documented on a generic array becomes an unsealed shape keeping the generic types,
     * and only the top-level `string` is removed from the type.
     */
    public function testArrayShapeOfGenericArrayIsUnsealed(): void
    {
        $code = <<<'PHP'
        <?php
        /**
         * @param string|array<string, string|bool> $args {
         *     Optional. Arguments.
         *
         *     @type bool                $in_footer     Whether to print in the footer.
         *     @type 'auto'|'low'|'high' $fetchpriority Fetch priority.
         * }
         */
        function wpstubs_test_generic_shape($args = []) {}
        PHP;

        $stubs = self::generateStubs($code);

        self::assertStringContainsString(
            "@phpstan-param array{\n *   in_footer?: bool,\n *   fetchpriority?: 'auto'|'low'|'high',\n *   ...<string, string|bool>,\n * } \$args",
            $stubs
        );
    }

    /**
     * A list of lists of array shapes is formatted as nested generic arrays.
     */
    public function testListOfListsOfArrayShapes(): void
    {
        $code = <<<'PHP'
        <?php
        /**
         * @param array[][] $fonts {
         *     Optional. Font families.
         *
         *     @type array ...$0 {
         *         Font variations.
         *
         *         @type array ...$0 {
         *             Font face.
         *
         *             @type string $font-family The font-family property.
         *             @type string $font-style  Optional. The font-style property. Default 'normal'.
         *         }
         *     }
         * }
         */
        function wpstubs_test_nested_lists($fonts = []) {}
        PHP;

        $stubs = self::generateStubs($code);

        self::assertStringContainsString(
            "@phpstan-param array<int|string, array<array-key, array{\n *   font-family: string,\n *   font-style?: string,\n * }>> \$fonts",
            $stubs
        );
    }

    /**
     * A parameter type from the function map replaces the one generated from the hash notation.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testMapParamReplacesGeneratedParam(): void
    {
        $code = <<<'PHP'
        <?php
        /**
         * @param array $args {
         *     Optional. Extra arguments that get passed to the callback function.
         *
         *     @type string $label_for Label.
         *     @type string $class     Class.
         * }
         */
        function add_settings_field($id, $title, $callback, $page, $section = 'default', $args = array()) {}
        PHP;

        $stubs = self::generateStubs($code);

        self::assertSame(1, substr_count($stubs, '@phpstan-param'), $stubs);
        self::assertStringContainsString('@phpstan-param array{label_for?: string, class?: string, ...} $args', $stubs);
    }

    /**
     * Function map parameters and templates do not duplicate the ones written in core.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testMapTagsDoNotDuplicateExistingTags(): void
    {
        $code = <<<'PHP'
        <?php
        /**
         * @param mixed $value The array or string to be stripped.
         * @return mixed The stripped value.
         *
         * @phpstan-template T
         * @phpstan-param T $value
         * @phpstan-return (T is string ? string : T)
         */
        function stripslashes_from_strings_only($value) {}
        PHP;

        $stubs = self::generateStubs($code);

        self::assertSame(1, substr_count($stubs, '@phpstan-template'), $stubs);
        self::assertSame(1, substr_count($stubs, '@phpstan-param'), $stubs);
        self::assertSame(1, substr_count($stubs, '@phpstan-return'), $stubs);
        self::assertStringContainsString('@phpstan-param T $value', $stubs);
        self::assertStringContainsString('@phpstan-pure', $stubs);
    }
}
