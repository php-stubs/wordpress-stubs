<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core;

use PHPStan\PhpDocParser\Ast\NodeTraverser;
use PHPStan\PhpDocParser\Ast\NodeVisitor\CloningVisitor;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\ConstExprParser;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use PHPStan\PhpDocParser\Parser\TypeParser;
use PHPStan\PhpDocParser\ParserConfig;
use PHPStan\PhpDocParser\Printer\Printer;

use function strtolower;

final class PhpDocFqcnRewriter
{
    private readonly Lexer $lexer;
    private readonly Printer $printer;
    private readonly PhpDocParser $docParser;

    public function __construct()
    {
        $config = new ParserConfig(['lines' => true, 'indexes' => true, 'comments' => true]);
        $constExprParser = new ConstExprParser($config);

        $this->lexer = new Lexer($config);
        $this->printer = new Printer();
        $this->docParser = new PhpDocParser($config, new TypeParser($config, $constExprParser), $constExprParser);
    }

    /**
     * @param array<string, string> $imports
     */
    public function rewrite(string $docComment, array $imports): string
    {
        if ($imports === []) {
            return $docComment;
        }

        $aliases = [];
        foreach ($imports as $alias => $fqcn) {
            $aliases[strtolower($alias)] = $fqcn;
        }

        $tokens = new TokenIterator($this->lexer->tokenize($docComment));
        $original = $this->docParser->parse($tokens);

        $rewritten = $this->cloningTraverser()->traverse([$original])[0];
        (new NodeTraverser([new PhpDocTypeNameResolver($aliases)]))->traverse([$rewritten]);

        return $this->printer->printFormatPreserving($rewritten, $original, $tokens);
    }

    private function cloningTraverser(): NodeTraverser
    {
        return new NodeTraverser([new CloningVisitor()]);
    }
}
