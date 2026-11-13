<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core;

use PHPStan\PhpDocParser\Ast\Attribute;
use PHPStan\PhpDocParser\Ast\PhpDoc;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\ConstExprParser;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use PHPStan\PhpDocParser\Parser\TypeParser;
use PHPStan\PhpDocParser\ParserConfig;

final class PhpStanTagMerger
{
    /** @param list<string> $additions */
    public function merge(string $comment, array $additions): string
    {
        $config = new ParserConfig(['indexes' => true]);
        $lexer = new Lexer($config);
        $constExprParser = new ConstExprParser($config);
        $parser = new PhpDocParser($config, new TypeParser($config, $constExprParser), $constExprParser);
        $tokens = new TokenIterator($lexer->tokenize($comment));
        $original = $parser->parse($tokens);
        $mapped = $parser->parse(new TokenIterator($lexer->tokenize(sprintf("/**\n * %s\n */", implode("\n * ", $additions)))));
        $keys = array_map([$this, 'getTagKey'], $mapped->getTags());

        $offset = 0;
        $parts = [];
        $rawTokens = $tokens->getTokens();
        foreach ($original->getTags() as $tag) {
            if (! in_array($this->getTagKey($tag), $keys, true)) {
                continue;
            }

            $start = $tag->getAttribute(Attribute::START_INDEX);
            $end = $tag->getAttribute(Attribute::END_INDEX);
            assert(is_int($start) && is_int($end));
            if ($start > $offset && $rawTokens[$start - 1][Lexer::TYPE_OFFSET] === Lexer::TOKEN_PHPDOC_EOL) {
                $start -= 1;
            }

            $parts[] = $tokens->getContentBetween($offset, $start);
            $offset = $end + 1;
        }
        $parts[] = $tokens->getContentBetween($offset, $tokens->getTokenCount());
        $comment = implode('', $parts);
        $closing = strrpos($comment, '*/');
        assert($closing !== false);

        return sprintf("%s\n * %s\n */", rtrim(substr($comment, 0, $closing)), implode("\n * ", $additions));
    }

    private function getTagKey(PhpDoc\PhpDocTagNode $tag): string
    {
        $tagValue = $tag->value;
        $target = '';
        if ($tagValue instanceof PhpDoc\ParamTagValueNode || $tagValue instanceof PhpDoc\ParamOutTagValueNode) {
            $target = $tagValue->parameterName;
        } elseif ($tagValue instanceof PhpDoc\TemplateTagValueNode) {
            $target = $tagValue->name;
        } elseif ($tagValue instanceof PhpDoc\PropertyTagValueNode) {
            $target = $tagValue->propertyName;
        } elseif ($tagValue instanceof PhpDoc\MethodTagValueNode) {
            $target = $tagValue->methodName;
        } elseif ($tagValue instanceof PhpDoc\TypeAliasTagValueNode) {
            $target = $tagValue->alias;
        } elseif ($tagValue instanceof PhpDoc\TypeAliasImportTagValueNode) {
            $target = $tagValue->importedAs ?? $tagValue->importedAlias;
        } elseif ($tagValue instanceof PhpDoc\ImplementsTagValueNode || $tagValue instanceof PhpDoc\ExtendsTagValueNode || $tagValue instanceof PhpDoc\UsesTagValueNode) {
            $target = ltrim($tagValue->type->type->name, '\\');
        } elseif ($tagValue instanceof PhpDoc\AssertTagValueNode) {
            $target = $tagValue->parameter;
        } elseif ($tagValue instanceof PhpDoc\InvalidTagValueNode) {
            // Do not replace unrelated malformed tags just because their names match.
            $target = (string)$tagValue;
        }

        return sprintf('%s:%s', $tag->name, $target);
    }
}
