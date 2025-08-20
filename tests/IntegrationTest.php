<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use PHPStan\Analyser\Analyser;
use PHPStan\Analyser\Error;
use PHPStan\Testing\PHPStanTestCase;

abstract class IntegrationTest extends PHPStanTestCase
{
    /**
     * @see https://github.com/phpstan/phpstan-src/blob/2.1.22/src/Testing/RuleTestCase.php
     *
     * @param list<array{0:string,1:int}> $expectedErrors
     */
    public function analyse(string $file, array $expectedErrors): void
    {
        $actualErrors = $this->runAnalyse($file);

        if ($expectedErrors === []) {
            $this->assertNoErrors($actualErrors);
            return;
        }

        $expected = array_map(
            static function (array $error): string {
                return self::formatError($error[1], $error[0]);
            },
            $expectedErrors
        );

        $actual = array_map(
            static function (Error $error): string {
                $line = $error->getLine() ?? -1;
                return self::formatError($line, $error->getMessage());
            },
            $actualErrors
        );

        $expectedString = implode("\n", $expected) . "\n";
        $actualString = implode("\n", $actual) . "\n";

        $this->assertSame($expectedString, $actualString);
    }

    /**
     * Format a single error line without tips or delayed-error context.
     */
    private static function formatError(int $line, string $message): string
    {
        return sprintf('%02d: %s', $line, trim($message));
    }

    /**
     * @see https://github.com/phpstan/phpstan-src/blob/2.1.22/tests/PHPStan/Analyser/AnalyserIntegrationTest.php
     *
     * @param array<string>|null $allAnalysedFiles
     * @return array<\PHPStan\Analyser\Error>
     */
    private function runAnalyse(string $file, ?array $allAnalysedFiles = null): array
    {
        $file = self::getFileHelper()->normalizePath($file);

        $analyser = self::getContainer()->getByType(Analyser::class);

        $errors = $analyser->analyse([$file], null, null, true, $allAnalysedFiles)->getErrors();

        foreach ($errors as $error) {
            $this->assertSame($file, $error->getFilePath(), 'Error file path mismatch.');
        }

        return $errors;
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/phpstan.neon'];
    }
}
