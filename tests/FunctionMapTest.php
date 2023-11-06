<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use PhpStubs\WordPress\Core\FunctionMap;

class FunctionMapTest extends \PHPStan\Testing\PHPStanTestCase
{
    /** @var ?\PhpStubs\WordPress\Core\FunctionMap $functionMap */
    private $functionMap;

    /**
     * @return list<array{0: 'function'|'class'|'method', 1: non-empty-array<int, string>, 2: array<int, string>, 3: 0|1}>
     */
    public function data(): array
    {
        /** @var non-empty-array<string, array<0|string, ?string>> */
        $functionMap = $this->getFunctionMap()->getMap();
        $data = [];
        foreach ($functionMap as $name => $params) {
            $context = self::getContextFromName($name);
            $nameAsArray = self::getNameAsArray($name);
            unset($params[0]);
            $params = array_keys($params);
            foreach ($params as $key => $param) {
                if (strpos($param, '@') !== 0) {
                    continue;
                }
                unset($params[$key]);
            }
            $data[] = [$context, $nameAsArray, $params, 1];
        }

        $data[] = ['function', ['nonExistentFunction'], [], 0];
        $data[] = ['class', ['NonExistentClass'], [], 0];
        $data[] = ['method', ['wpdb', 'nonExistentMethod'], [], 0];
        $data[] = ['method', ['NonExistentClass', 'nonExistentMethod'], [], 0];
        return $data;
    }

    /**
     * @return list<array{0: 'function'|'class'|'method', 1: non-empty-array<int, string>, 2: array<int, string>, 3: 0|1}>
     */
    public function dataParameters(): array
    {
        $data = $this->data();
        $data = array_filter(
            $data,
            static function (array $item): bool {
                return $item[0] !== 'class' && count($item[2]) !== 0;
            }
        );
        $data[] = ['function', ['get_post'], ['nonExistentParameter'], 0];
        return $data;
    }

    /**
     * @dataProvider data
     * @param 'function'|'class'|'method' $context
     * @param ($context is 'method' ? array{0: string, 1: string} : array{0: string}) $name
     * @param list<string> $params
     * @param 0|1 $expected
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function testExists(string $context, array $name, array $params, int $expected): void
    {
        switch ($context) {
            case 'function':
                $result = function_exists($name[0]);
                break;
            case 'class':
                $result = class_exists($name[0]);
                break;
            case 'method':
                $result = method_exists($name[0], $name[1]);
                break;
            default:
                $result = false;
        }

        self::assertSame((bool)$expected, $result, $this->notExistsMsg($context, $name));
    }

    /**
     * @dataProvider dataParameters
     * @param 'function'|'method' $context
     * @param ($context is 'method' ? array{0: string, 1: string} : array{0: string}) $name
     * @param list<string> $params
     * @param 0|1 $expected
     */
    public function testParameterNames(string $context, array $name, array $params, int $expected): void
    {
        $reflection = $context === 'function'
            ? new \ReflectionFunction($name[0])
            : new \ReflectionMethod($name[0], $name[1]);

        $paramNames = array_map(
            static function (\ReflectionParameter $parameter): string {
                return $parameter->getName();
            },
            $reflection->getParameters()
        );

        foreach ($params as $param) {
            self::assertSame(
                (bool)$expected,
                in_array($param, $paramNames, true),
                self::incorrectParamNameMsg($context, $name, $param)
            );
        }
    }

    /**
     * @dataProvider dataParameters
     * @param 'function'|'method' $context
     * @param ($context is 'method' ? array{0: string, 1: string} : array{0: string}) $name
     * @param list<string> $params
     * @param 0|1 $expected
     */
    public function testParameters(string $context, array $name, array $params, int $expected): void
    {
        $reflection = $context === 'function'
            ? new \ReflectionFunction($name[0])
            : new \ReflectionMethod($name[0], $name[1]);

        $docComment = $reflection->getDocComment();
        if ($docComment === false) {
            throw new \RuntimeException(
                sprintf(
                    'No doc comment found for %s "%s()".',
                    $context,
                    $context === 'method' ? implode('::', $name) : $name[0]
                )
            );
        }

        $docComment = preg_replace('/\s+/', ' ', $docComment) ?? '';
        $docComment = preg_replace('/(@phpstan-param).*(\$)/sU', '$1 $2', $docComment) ?? '';

        foreach ($params as $param) {
            $count = substr_count($docComment, sprintf('@phpstan-param $%s', $param));
            self::assertSame(
                $expected,
                $count,
                self::incorrectNumberMsg($context, $name, $param, $count)
            );
        }
    }

    /**
     * @param 'function'|'class'|'method' $context
     * @param non-empty-array<int, string> & ($context is 'method' ? array{0: string, 1: string} : array{0: string}) $name
     */
    private static function notExistsMsg(string $context, array $name): string
    {
        return sprintf(
            'FunctionMap: %s "%s()" does not exist in stubs file.',
            ucwords($context),
            $context === 'method' ? implode('::', $name) : $name[0]
        );
    }

    /**
     * @param 'function'|'method' $context
     * @param non-empty-array<int, string> & ($context is 'method' ? array{0: string, 1: string} : array{0: string}) $name
     */
    private static function incorrectParamNameMsg(string $context, array $name, string $paramName): string
    {
        return sprintf(
            'FunctionMap: Parameter "%s" of %s "%s()" not found in stubs file.',
            $paramName,
            $context,
            $context === 'method' ? implode('::', $name) : $name[0]
        );
    }

    /**
     * @param 'function'|'method' $context
     * @param non-empty-array<int, string> & ($context is 'method' ? array{0: string, 1: string} : array{0: string}) $name
     */
    private static function incorrectNumberMsg(string $context, array $name, string $param, int $count): string
    {
        return sprintf(
            'FunctionMap: Expected exactly 1 @phpstan-param tag for parameter "%s" of %s "%s(). Found %d tags.',
            $param,
            $context,
            $context === 'method' ? implode('::', $name) : $name[0],
            $count
        );
    }

    /**
     * @return non-empty-array<int, string>
     */
    private static function getNameAsArray(string $name): array
    {
        return self::getContextFromName($name) === 'method'
            ? explode('::', $name)
            : [$name];
    }

    /**
     * @return 'function'|'class'|'method'
     */
    private static function getContextFromName(string $name): string
    {
        $classes = ['WP_Block_List', 'WP_REST_Request', 'WP_Theme'];

        if (strpos($name, '::') !== false) {
            return 'method';
        }

        return in_array($name, $classes, true) ? 'class' : 'function';
    }

    private function getFunctionMap(): FunctionMap
    {
        if ($this->functionMap === null) {
            $this->functionMap = new FunctionMap();
        }

        return $this->functionMap;
    }

    /**
     * @return list<string>
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [
            sprintf('%s/phpstan.neon', __DIR__),
        ];
    }
}
