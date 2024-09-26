<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

/**
 * @phpstan-type Types array{
 *   bool: bool,
 *   int: int,
 *   float: float,
 *   string: string,
 *   array: array<mixed>,
 *   resource: resource,
 *   object: object,
 *   numeric-string: numeric-string,
 *   null: null,
 *   mixed: mixed,
 *   true: true,
 *   false: false,
 *   callable: callable,
 *   iterable: iterable<mixed>,
 *   array-key: array-key,
 *   positive-int: positive-int,
 *   negative-int: negative-int,
 *   non-positive-int: non-positive-int,
 *   non-negative-int: non-negative-int,
 *   non-zero-int: non-zero-int,
 * }
 */
class Faker
{
    /**
     * @var Types $types
     * @phpstan-ignore-next-line
     */
    private static $types;

    /**
     * @template T of string
     * @param T $type
     * @return Types[T]
     */
    public static function fake(string $type): mixed
    {
        return self::$types[$type];
    }

    /**
     * @template T of string
     * @template K of string
     * @param T $valueType
     * @param K $keyType
     * @return array<Types[K], Types[T]>
     */
    public static function fakeArray(string $valueType, string $keyType = 'array-key'): mixed
    {
        return [$_GET[$keyType], $_GET[$valueType]];
    }

    /**
     * @template T of non-empty-array<key-of<Types>>
     * @param T $types
     * @return Types[value-of<T>]
     */
    public static function or(array $types): mixed
    {
        foreach ($types as $type) {
            if ($_GET['thing'] === $type) {
                return self::fake($type);
            }
        }
        return self::fake($types[0]);
    }
}
