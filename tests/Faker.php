<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

/**
 * Class that provides fake types via docBlocks for type testing.
 *
 * @method static bool bool()
 * @method static true true()
 * @method static false false()
 * @method static int int()
 * @method static positive-int positiveInt()
 * @method static negative-int negativeInt()
 * @method static non-positive-int nonPositiveInt()
 * @method static non-negative-int nonNegativeInt()
 * @method static non-zero-int nonZeroInt()
 * @method static float float()
 * @method static string string()
 * @method static non-empty-string nonEmptyString()
 * @method static numeric-string numericString()
 * @method static resource resource()
 * @method static object object()
 * @method static mixed mixed()
 * @method static callable callable()
 * @method static \stdClass stdClass()
 * @method static \WP_Post wpPost()
 * @method static \WP_Term wpTerm()
 * @method static \WP_Comment wpComment()
 * @method static \WP_REST_Request wpRestRequest()
 * @method static \WP_Theme wpTheme()
 * @method static \WP_Translations wpTranslations()
 * @method static \WP_Query wpQuery()
 * @method static \WP_Widget_Factory wpWidgetFactory()
 */
class Faker
{
    /**
     * Fakes `array<Type>`. If `$type` is `null`, fakes `array<mixed>`.
     *
     * @template T
     * @param T $type
     * @return ($type is null ? array<array-key, mixed> : array<array-key, T>)
     */
    public static function array($type = null): array
    {
        return [$type];
    }

    /**
     * Fakes `array<int, Type>`. If `$type` is `null`, fakes `array<int, mixed>`.
     *
     * @template T
     * @param T|null $type
     * @return ($type is null ? array<int, mixed> : array<int, T>)
     */
    public static function intArray($type = null): array
    {
        return [$type];
    }

    /**
     * Fakes `array<string, Type>`. If `$type` is `null`, fakes `array<string, mixed>`.
     *
     * @template T
     * @param T|null $type
     * @return ($type is null ? array<string, mixed>: array<string, T>)
     */
    public static function strArray($type = null): array
    {
        return [self::string() => $type];
    }

    /**
     * Fakes `list<Type>`. If `$type` is `null`, fakes `list<mixed>`.
     *
     * @template T
     * @param T|null $type
     * @return ($type is null ? list<mixed> : list<T>)
     */
    public static function list($type = null): array
    {
        return [$type];
    }

    /**
     * @template T
     * @param T ...$types
     * @return T
     */
    public static function union(...$types): mixed
    {
        return $types[0];
    }
}
