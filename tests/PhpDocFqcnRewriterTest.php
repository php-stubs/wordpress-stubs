<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use PhpStubs\WordPress\Core\PhpDocFqcnRewriter;
use PHPUnit\Framework\TestCase;

// phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength

final class PhpDocFqcnRewriterTest extends TestCase
{
    /**
     * @dataProvider provideDocBlocks
     * @param array<string, string> $aliases
     */
    public function testRewrite(array $aliases, string $input, string $expected): void
    {
        $rewriter = new PhpDocFqcnRewriter();
        self::assertSame($expected, $rewriter->rewrite($input, $aliases));
    }

    /**
     * @return iterable<string, array{array<string, string>, string, string}>
     */
    public static function provideDocBlocks(): iterable
    {
        $std = [
            'Foo' => '\Acme\Foo',
            'Bar' => '\Acme\Bar',
            'Baz' => '\Acme\Baz',
            'Message' => '\Acme\Messages\Message',
            'Coll' => '\Acme\Collection',
            'Sub' => '\Acme\Sub',
            'Qux' => '\Acme\Aliased',
            'Ex' => '\Acme\Exceptions\MyException',
        ];

        // Type annotations in various tags.
        yield '@param' => [$std, '/** @param Foo $x */', '/** @param \Acme\Foo $x */'];
        yield '@return' => [$std, '/** @return Foo */', '/** @return \Acme\Foo */'];
        yield '@var with element name' => [$std, '/** @var Foo $bar */', '/** @var \Acme\Foo $bar */'];
        yield '@var without element name' => [$std, '/** @var Foo */', '/** @var \Acme\Foo */'];
        yield '@throws' => [$std, '/** @throws Ex */', '/** @throws \Acme\Exceptions\MyException */'];
        yield '@property' => [$std, '/** @property Foo $x */', '/** @property \Acme\Foo $x */'];
        yield '@property-read' => [$std, '/** @property-read Foo $x */', '/** @property-read \Acme\Foo $x */'];
        yield '@property-write' => [$std, '/** @property-write Foo $x */', '/** @property-write \Acme\Foo $x */'];
        yield '@method return and param' => [
            $std,
            '/** @method Foo doThing(Baz $b) */',
            '/** @method \Acme\Foo doThing(\Acme\Baz $b) */',
        ];
        yield '@method static return type' => [
            $std,
            '/** @method static Foo make() */',
            '/** @method static \Acme\Foo make() */',
        ];
        yield '@method multiple params' => [
            $std,
            '/** @method Bar handle(Foo $a, Baz $b, int $c) */',
            '/** @method \Acme\Bar handle(\Acme\Foo $a, \Acme\Baz $b, int $c) */',
        ];
        yield '@mixin' => [$std, '/** @mixin Foo */', '/** @mixin \Acme\Foo */'];

        // PHPStan-specific tags.
        yield '@phpstan-param' => [$std, '/** @phpstan-param Foo $x */', '/** @phpstan-param \Acme\Foo $x */'];
        yield '@phpstan-return' => [$std, '/** @phpstan-return Foo */', '/** @phpstan-return \Acme\Foo */'];
        yield '@phpstan-var' => [$std, '/** @phpstan-var Foo $x */', '/** @phpstan-var \Acme\Foo $x */'];
        yield '@phpstan-type right-hand side' => [
            $std,
            '/** @phpstan-type Prompt Foo|Message|int */',
            '/** @phpstan-type Prompt \Acme\Foo|\Acme\Messages\Message|int */',
        ];
        yield '@phpstan-import-type from target' => [
            $std,
            '/** @phpstan-import-type Shape from Message */',
            '/** @phpstan-import-type Shape from \Acme\Messages\Message */',
        ];
        yield '@phpstan-import-type with as' => [
            $std,
            '/** @phpstan-import-type Shape from Message as Renamed */',
            '/** @phpstan-import-type Shape from \Acme\Messages\Message as Renamed */',
        ];

        // Type expressions in various forms.
        yield 'union' => [$std, '/** @param Foo|Bar $x */', '/** @param \Acme\Foo|\Acme\Bar $x */'];
        yield 'union with builtin' => [$std, '/** @param Foo|null $x */', '/** @param \Acme\Foo|null $x */'];
        yield 'nullable shorthand' => [$std, '/** @param ?Foo $x */', '/** @param ?\Acme\Foo $x */'];
        yield 'intersection' => [$std, '/** @param Foo&Bar $x */', '/** @param \Acme\Foo&\Acme\Bar $x */'];
        yield 'generic list' => [$std, '/** @param list<Foo> $x */', '/** @param list<\Acme\Foo> $x */'];
        yield 'generic array with key' => [
            $std,
            '/** @param array<int, Foo> $x */',
            '/** @param array<int, \Acme\Foo> $x */',
        ];
        yield 'generic custom collection' => [
            $std,
            '/** @param Coll<Foo> $x */',
            '/** @param \Acme\Collection<\Acme\Foo> $x */',
        ];
        yield 'array shape' => [
            $std,
            '/** @param array{a: Foo, b?: Bar} $x */',
            '/** @param array{a: \Acme\Foo, b?: \Acme\Bar} $x */',
        ];
        yield 'nested generics' => [
            $std,
            '/** @param array<int, list<Foo>> $x */',
            '/** @param array<int, list<\Acme\Foo>> $x */',
        ];
        yield 'callable' => [
            $std,
            '/** @param callable(Foo): Bar $x */',
            '/** @param callable(\Acme\Foo): \Acme\Bar $x */',
        ];
        yield 'variadic' => [$std, '/** @param Foo ...$x */', '/** @param \Acme\Foo ...$x */'];
        yield 'by reference' => [$std, '/** @param Foo &$x */', '/** @param \Acme\Foo &$x */'];
        yield 'class-string generic' => [
            $std,
            '/** @param class-string<Foo> $x */',
            '/** @param class-string<\Acme\Foo> $x */',
        ];

        // Types that are imported via an alias.
        yield 'aliased import' => [$std, '/** @param Qux $x */', '/** @param \Acme\Aliased $x */'];
        yield 'qualified name, imported first segment' => [
            $std,
            '/** @param Sub\Deep $x */',
            '/** @param \Acme\Sub\Deep $x */',
        ];
        yield 'case-insensitive alias match' => [$std, '/** @param foo $x */', '/** @param \Acme\Foo $x */'];

        // Reserved words and built-in types that should not be rewritten.
        yield 'builtin scalar untouched' => [$std, '/** @param string $x */', '/** @param string $x */'];
        yield 'builtin array untouched' => [$std, '/** @param array $x */', '/** @param array $x */'];
        yield 'reserved static untouched' => [$std, '/** @return static */', '/** @return static */'];
        yield 'reserved self untouched' => [$std, '/** @return self */', '/** @return self */'];
        yield 'pseudo-type list untouched' => [$std, '/** @return list */', '/** @return list */'];
        yield 'already fully qualified untouched' => [
            $std,
            '/** @param \Already\Qualified $x */',
            '/** @param \Already\Qualified $x */',
        ];
        yield 'unimported same-namespace class untouched' => [
            $std,
            '/** @param NotImported $x */',
            '/** @param NotImported $x */',
        ];
        yield 'local type alias untouched' => [$std, '/** @param Prompt $x */', '/** @param Prompt $x */'];
        yield 'class name in description untouched' => [
            $std,
            '/** @param Foo $x A Foo instance to use. */',
            '/** @param \Acme\Foo $x A Foo instance to use. */',
        ];

        // Formatting and layout preservation.
        yield 'multi-line layout preserved' => [
            $std,
            <<<'DOC'
                /**
                 * Does a thing with a Foo.
                 *
                 * @since 1.2.3
                 *
                 * @param Foo      $foo   The foo to use.
                 * @param int      $count How many.
                 * @return Bar             The result.
                 * @throws Ex              When it breaks.
                 */
                DOC,
            <<<'DOC'
                /**
                 * Does a thing with a Foo.
                 *
                 * @since 1.2.3
                 *
                 * @param \Acme\Foo      $foo   The foo to use.
                 * @param int      $count How many.
                 * @return \Acme\Bar             The result.
                 * @throws \Acme\Exceptions\MyException              When it breaks.
                 */
                DOC,
        ];
        yield 'multiple tags in one block' => [
            $std,
            <<<'DOC'
                /**
                 * @param Foo $a
                 * @param Bar $b
                 * @return Baz
                 */
                DOC,
            <<<'DOC'
                /**
                 * @param \Acme\Foo $a
                 * @param \Acme\Bar $b
                 * @return \Acme\Baz
                 */
                DOC,
        ];
        yield 'empty alias map leaves everything untouched' => [
            [],
            '/** @param Foo $x */',
            '/** @param Foo $x */',
        ];
        yield 'unparseable input returned unchanged' => [
            $std,
            'this is not a doc comment',
            'this is not a doc comment',
        ];

        // Types in array/object shapes.
        yield 'shape key matching import left alone' => [
            $std,
            '/** @param array{message: string, body: Bar} $x */',
            '/** @param array{message: string, body: \Acme\Bar} $x */',
        ];
        yield 'object shape key left alone' => [
            $std,
            '/** @return object{message: int} */',
            '/** @return object{message: int} */',
        ];
        yield 'class constant type qualified' => [
            $std,
            '/** @return Foo::TYPE_X */',
            '/** @return \Acme\Foo::TYPE_X */',
        ];
        yield 'enum case wildcard qualified' => [
            $std,
            '/** @param Foo::* $x */',
            '/** @param \Acme\Foo::* $x */',
        ];
        yield 'old-style array suffix' => [
            $std,
            '/** @param Foo[] $x */',
            '/** @param \Acme\Foo[] $x */',
        ];

        // Template annotations.
        yield 'template shadows import' => [
            $std,
            <<<'DOC'
                /**
                 * @template Foo
                 * @param Foo $x
                 * @return Bar
                 */
                DOC,
            <<<'DOC'
                /**
                 * @template Foo
                 * @param Foo $x
                 * @return \Acme\Bar
                 */
                DOC,
        ];
    }
}
