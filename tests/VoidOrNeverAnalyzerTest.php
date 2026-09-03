<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\Types\Never_;
use phpDocumentor\Reflection\Types\Void_;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\NodeFinder;
use PhpParser\ParserFactory;
use PhpStubs\WordPress\Core\VoidOrNeverAnalyzer;
use PHPUnit\Framework\TestCase;

final class VoidOrNeverAnalyzerTest extends TestCase
{
    /** Analyzer inferred void type */
    private const RESULT_VOID = 'void';
    /** Analyzer inferred never type */
    private const RESULT_NEVER = 'never';
    /** Analyzed, but no type inferred */
    private const RESULT_NULL = 'null';
    /** Analyzer skipped node */
    private const RESULT_SKIPPED = 'skipped';

    /**
     * Runs the analyzer on the first function or method declared in a snippet.
     *
     * @return self::RESULT_*
     */
    private static function analyze(string $code): string
    {
        $nodeFinder = new NodeFinder();
        $analyzer = new VoidOrNeverAnalyzer($nodeFinder, DocBlockFactory::createInstance());

        $stmts = (new ParserFactory())->createForNewestSupportedVersion()->parse($code);
        self::assertNotNull($stmts);

        $node = $nodeFinder->findFirst(
            $stmts,
            static function (Node $node): bool {
                return $node instanceof Function_ || $node instanceof ClassMethod;
            }
        );
        self::assertInstanceOf(Node::class, $node);

        $analyzer->setAttribute($node);

        if (! $node->hasAttribute(VoidOrNeverAnalyzer::ATTRIBUTE_NAME)) {
            return self::RESULT_SKIPPED;
        }

        $type = $node->getAttribute(VoidOrNeverAnalyzer::ATTRIBUTE_NAME);

        if ($type instanceof Void_) {
            return self::RESULT_VOID;
        }

        if ($type instanceof Never_) {
            return self::RESULT_NEVER;
        }

        self::assertNull($type);

        return self::RESULT_NULL;
    }

    /**
     * Wraps a function body in a documented function declaration.
     */
    private static function documentedFunction(string $body): string
    {
        return <<<PHP
        <?php
        /**
         * Description.
         */
        function wpstubs_test_function() {
            $body
        }
        PHP;
    }

    /**
     * @dataProvider skippedNodesProvider
     */
    public function testShouldNotAnalyze(string $code): void
    {
        self::assertSame(self::RESULT_SKIPPED, self::analyze($code));
    }

    /**
     * @return array<string, array{string}>
     */
    public function skippedNodesProvider(): array
    {
        return [
            'native return type' => [
                <<<'PHP'
                <?php
                /**
                 * Description.
                 */
                function wpstubs_test_function(): void {
                    echo 'Hello';
                }
                PHP,
            ],
            'constructor' => [
                <<<'PHP'
                <?php
                class WPStubs_Test_Class {
                    /**
                     * Description.
                     */
                    public function __construct() {
                        echo 'Hello';
                    }
                }
                PHP,
            ],
            'abstract method' => [
                <<<'PHP'
                <?php
                abstract class WPStubs_Test_Class {
                    /**
                     * Description.
                     */
                    abstract public function method();
                }
                PHP,
            ],
            'interface method' => [
                <<<'PHP'
                <?php
                interface WPStubs_Test_Interface {
                    /**
                     * Description.
                     */
                    public function method();
                }
                PHP,
            ],
            'empty body' => [self::documentedFunction('')],
            'generator with yield' => [self::documentedFunction('yield 1;')],
            'generator with yield from' => [self::documentedFunction('yield from [1, 2];')],
            'missing docblock' => [
                <<<'PHP'
                <?php
                function wpstubs_test_function() {
                    echo 'Hello';
                }
                PHP,
            ],
            'deprecated function' => [
                <<<'PHP'
                <?php
                /**
                 * @deprecated 1.2.3
                 */
                function wpstubs_test_function() {
                    echo 'Hello';
                }
                PHP,
            ],
            'pseudo-abstract function' => [
                <<<'PHP'
                <?php
                /**
                 * @abstract
                 */
                function wpstubs_test_function() {
                    echo 'Hello';
                }
                PHP,
            ],
            'existing @return tag' => [
                <<<'PHP'
                <?php
                /**
                 * @return void
                 */
                function wpstubs_test_function() {
                    echo 'Hello';
                }
                PHP,
            ],
            'existing @phpstan-return tag' => [
                <<<'PHP'
                <?php
                /**
                 * @phpstan-return void
                 */
                function wpstubs_test_function() {
                    echo 'Hello';
                }
                PHP,
            ],
        ];
    }

    public function testNodesOtherThanFunctionsAreIgnored(): void
    {
        $stmts = (new ParserFactory())->createForNewestSupportedVersion()->parse(
            <<<'PHP'
            <?php
            /**
             * Description.
             */
            class WPStubs_Test_Class {
            }
            PHP
        );
        self::assertNotNull($stmts);
        self::assertInstanceOf(Class_::class, $stmts[0]);

        $analyzer = new VoidOrNeverAnalyzer(new NodeFinder(), DocBlockFactory::createInstance());
        $analyzer->setAttribute($stmts[0]);

        self::assertFalse($stmts[0]->hasAttribute(VoidOrNeverAnalyzer::ATTRIBUTE_NAME));
    }

    /**
     * @dataProvider inferredTypeProvider
     */
    public function testReturnTypeIsInferred(string $code, string $expected): void
    {
        self::assertSame($expected, self::analyze($code));
    }

    /**
     * @return array<string, array{string, string}>
     */
    public function inferredTypeProvider(): array
    {
        return [
            'no return statement' => [
                self::documentedFunction("echo 'Hello';"),
                self::RESULT_VOID,
            ],
            'empty return statement' => [
                self::documentedFunction('return;'),
                self::RESULT_VOID,
            ],
            'conditional empty return statement' => [
                self::documentedFunction("if (true) {\n        return;\n    }\n    echo 'Hello';"),
                self::RESULT_VOID,
            ],
            'return with expression' => [
                self::documentedFunction('return 1;'),
                self::RESULT_NULL,
            ],
            'nested return with expression' => [
                self::documentedFunction("if (true) {\n        return 1;\n    }\n    return;"),
                self::RESULT_NULL,
            ],
            'method without return statement' => [
                <<<'PHP'
                <?php
                class WPStubs_Test_Class {
                    /**
                     * Description.
                     */
                    public function method() {
                        echo 'Hello';
                    }
                }
                PHP,
                self::RESULT_VOID,
            ],
            'protected method without return statement' => [
                <<<'PHP'
                <?php
                class WPStubs_Test_Class {
                    /**
                     * Description.
                     */
                    protected function method() {
                        echo 'Hello';
                    }
                }
                PHP,
                self::RESULT_VOID,
            ],
            'top level exit' => [
                self::documentedFunction('exit;'),
                self::RESULT_NEVER,
            ],
            'top level exit with code' => [
                self::documentedFunction('exit(1);'),
                self::RESULT_NEVER,
            ],
            'top level exit meant to be overridden' => [
                self::documentedFunction("exit('Method must be overridden.');"),
                self::RESULT_VOID,
            ],
            'exit inside a condition' => [
                self::documentedFunction("if (true) {\n        exit;\n    }"),
                self::RESULT_VOID,
            ],
            'top level throw' => [
                self::documentedFunction('throw new \RuntimeException();'),
                self::RESULT_NEVER,
            ],
            'top level throw with message' => [
                self::documentedFunction("throw new \RuntimeException('Not implemented.');"),
                self::RESULT_NEVER,
            ],
            'top level throw meant to be overridden' => [
                self::documentedFunction("throw new \RuntimeException('Method must be overridden.');"),
                self::RESULT_VOID,
            ],
            'top level throw of a variable' => [
                self::documentedFunction('throw $exception;'),
                self::RESULT_VOID,
            ],
            'wp_send_json call' => [
                self::documentedFunction("wp_send_json(['a' => 1]);"),
                self::RESULT_NEVER,
            ],
            'wp_send_json_success call' => [
                self::documentedFunction('wp_send_json_success();'),
                self::RESULT_NEVER,
            ],
            'wp_send_json_error call' => [
                self::documentedFunction('wp_send_json_error();'),
                self::RESULT_NEVER,
            ],
            'other function call' => [
                self::documentedFunction("wp_safe_redirect('/');"),
                self::RESULT_VOID,
            ],
            'dynamic function call' => [
                self::documentedFunction('$callback();'),
                self::RESULT_VOID,
            ],
            'wp_die without arguments' => [
                self::documentedFunction('wp_die();'),
                self::RESULT_NEVER,
            ],
            'wp_die with message and title' => [
                self::documentedFunction("wp_die('message', 'title');"),
                self::RESULT_NEVER,
            ],
            'wp_die with status code' => [
                self::documentedFunction("wp_die('message', 'title', 403);"),
                self::RESULT_NEVER,
            ],
            'wp_die with empty options' => [
                self::documentedFunction("wp_die('message', 'title', []);"),
                self::RESULT_NEVER,
            ],
            'wp_die with truthy exit option' => [
                self::documentedFunction("wp_die('message', 'title', ['exit' => true]);"),
                self::RESULT_NEVER,
            ],
            'wp_die with falsy exit option' => [
                self::documentedFunction("wp_die('message', 'title', ['exit' => false]);"),
                self::RESULT_VOID,
            ],
            'wp_die with unresolvable options' => [
                self::documentedFunction("wp_die('message', 'title', \$args);"),
                self::RESULT_VOID,
            ],
            'wp_die with string options' => [
                self::documentedFunction("wp_die('message', 'title', 'back_link');"),
                self::RESULT_VOID,
            ],
        ];
    }
}
