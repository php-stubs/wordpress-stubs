<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

class TypeHelper
{
    public bool $bool;

    public int $int;

    /** @var positive-int $posInt */
    public int $posInt;

    /** @var negative-int $negInt */
    public int $negInt;

    public string $string;

    /** @var array<array-key, mixed> $array */
    public array $array;

    /** @var array<string, mixed> $arrayA */
    public array $arrayA;

    /** @var array<int, mixed> $arrayN */
    public array $arrayN;

    public object $object;

    public \WP_Post $wpPost; // @phpstan-ignore-line

    public \WP_Error $wpError; // @phpstan-ignore-line

    /** @var int|string $intOrString */
    public $intOrString;

    /** @var int|object $intOrObject */
    public $intOrObject;

    /** @var int|\WP_Post $intOrWpPost */
    public $intOrWpPost; // @phpstan-ignore-line

    /**
     * @phpstan-template T
     * @phpstan-template OT
     * @phpstan-param T $type
     * @phpstan-param OT $otherType
     * @phpstan-return T|OT
     */
    public static function or(mixed $type, mixed $otherType): mixed
    {
        return isset($_GET['foo']) ? $type : $otherType;
    }

    /**
     * @phpstan-template T
     * @phpstan-param T $type
     * @phpstan-return T|string
     */
    public static function stringOr(mixed $type): mixed
    {
        return isset($_GET['foo']) ? $type : (string)$_GET['bar'];
    }

    /**
     * @phpstan-template T
     * @phpstan-param T $type
     * @phpstan-return T|int
     */
    public static function intOr(mixed $type): mixed
    {
        return isset($_GET['foo']) ? $type : (int)$_GET['bar'];
    }

    /**
     * @phpstan-template T
     * @phpstan-param T $type
     * @phpstan-return T|null
     */
    public static function addNull(mixed $type): mixed
    {
        return isset($_GET['foo']) ? $type : null;
    }
}
