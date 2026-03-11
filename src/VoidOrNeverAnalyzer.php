<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core;

use phpDocumentor\Reflection\DocBlockFactoryInterface;
use phpDocumentor\Reflection\Types\Never_;
use phpDocumentor\Reflection\Types\Void_;
use PhpParser\ConstExprEvaluator;
use PhpParser\Node;
use PhpParser\Node\Expr\Exit_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Throw_;
use PhpParser\Node\Expr\Yield_;
use PhpParser\Node\Expr\YieldFrom;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Return_;
use PhpParser\NodeFinder;

use function array_key_exists;
use function is_array;
use function is_int;
use function count;

final class VoidOrNeverAnalyzer
{
    public const ATTRIBUTE_NAME = 'WPStubs_voidOrNever';

    private NodeFinder $nodeFinder;
    private DocBlockFactoryInterface $docBlockFactory;

    public function __construct(NodeFinder $nodeFinder, DocBlockFactoryInterface $docBlockFactory) {
        $this->nodeFinder = $nodeFinder;
        $this->docBlockFactory = $docBlockFactory;
    }

    public function setAttribute(Node $node): void
    {
        if (! $this->shouldAnalyze($node)) {
            return;
        }

        $returnStmts = $this->nodeFinder->findInstanceOf($node, Return_::class);

        if (count($returnStmts) !== 0) {
            $this->analyzeWithReturns($node, $returnStmts);
            return;
        }

        // Infer never return type.
        $this->analyzeWithoutReturns($node);
    }

    /**
     * @phpstan-assert-if-true \PhpParser\Node\Stmt\Function_|\PhpParser\Node\Stmt\ClassMethod $node
     */
    private function shouldAnalyze(Node $node): bool
    {
        if (! ($node instanceof Function_) && ! ($node instanceof ClassMethod)) {
            return false;
        }

        if (
            $node instanceof ClassMethod
            && strtolower($node->name->name) === '__construct'
        ) {
            return false;
        }

        if ($node->getReturnType() !== null) {
            return false;
        }

        if (! isset($node->stmts) || count($node->stmts) === 0) {
            // Interfaces and abstract methods.
            return false;
        }

        $yields = $this->nodeFinder->findFirst(
            $node,
            static function (Node $node): bool {
                return $node instanceof Yield_ || $node instanceof YieldFrom;
            }
        ) instanceof Node;

        // Generator functions do not return void or never.
        if ($yields) {
            return false;
        }

        try {
            $docBlock = $this->docBlockFactory->create($node->getDocComment()?->getText() ?? '');
        } catch (\RuntimeException | \InvalidArgumentException $e) {
            // Skip if the docblock is invalid.
            return false;
        }

        // Skip deprecated and pseudo-abstract functions.
        if (
            $docBlock->getTagsByName('deprecated') !== []
            || $docBlock->getTagsByName('abstract') !== []
        ) {
            return false;
        }

        // Skip if there is already a @return or @phpstan-return tag.
        return $docBlock->getTagsByName('return') === []
            && $docBlock->getTagsByName('phpstan-return') === [];
    }

    /**
     * @param \PhpParser\Node\Stmt\Function_|\PhpParser\Node\Stmt\ClassMethod $node
     * @param array<\PhpParser\Node\Stmt\Return_> $returnStmts
     */
    private function analyzeWithReturns(Node $node, array $returnStmts): void
    {
        $hasNonVoidReturn = $this->nodeFinder->findFirst(
            $returnStmts,
            static function (Node $node): bool {
                return property_exists($node, 'expr') && $node->expr !== null;
            }
        ) instanceof Node;

        if ($hasNonVoidReturn) {
            return;
        }

        $node->setAttribute(self::ATTRIBUTE_NAME, new Void_());
    }

    /**
     * @param \PhpParser\Node\Stmt\Function_|\PhpParser\Node\Stmt\ClassMethod $node
     */
    private function analyzeWithoutReturns(Node $node): void
    {
        foreach ((array)$node->stmts as $stmt) {
            if (! ($stmt instanceof Expression)) {
                continue;
            }

            if (
                ! $this->isTopLevelExitOrThrow($stmt)
                && ! $this->isTopLevelNeverFunctionCall($stmt)
            ) {
                continue;
            }

            $node->setAttribute(self::ATTRIBUTE_NAME, new Never_());
            return;
        }
    }

    private function isTopLevelExitOrThrow(Expression $stmt): bool
    {
        if (! ($stmt->expr instanceof Exit_ || $stmt->expr instanceof Throw_)) {
            return false;
        }

        if (! ($stmt->expr->expr instanceof String_)) {
            return true;
        }

        // Skip throw/exit for functions that are meant to be overridden.
        return ! $this->isMeantToBeOverridden($stmt->expr->expr);
    }

    private function isMeantToBeOverridden(String_ $message): bool
    {
        $message = strtolower($message->value);
        return str_contains($message, 'override')
            || str_contains($message, 'overridden');
    }

    private function isTopLevelNeverFunctionCall(Expression $stmt): bool
    {
        if (! ($stmt->expr instanceof FuncCall) || ! ($stmt->expr->name instanceof Name)) {
            return false;
        }

        $name = $stmt->expr->name->toLowerString();

        // A top-level call to wp_send_json(_success/error) implies return type never.
        if (str_starts_with($name, 'wp_send_json')) {
            return true;
        }

        // wp_die() needs additional checks.
        if (str_starts_with($name, 'wp_die')) {
            return $this->isNeverFromWpDieCall($stmt->expr);
        }

        return false;
    }

    private function isNeverFromWpDieCall(FuncCall $funcCall): bool
    {
        $args = $funcCall->getArgs();

        // If wp_die is called without 3rd parameter, it's return type never.
        if (count($args) < 3) {
            return true;
        }

        // If wp_die is called with 3rd parameter, we need additional checks.
        try {
            $arg = (new ConstExprEvaluator())->evaluateSilently($args[2]->value);
        } catch (\PhpParser\ConstExprEvaluationException $e) {
            // If we don't know the value of the 3rd parameter, we can't be sure.
            return false;
        }

        // Integer argument means it will exit.
        if (is_int($arg)) {
            return true;
        }

        if (! is_array($arg)) {
            return false;
        }

        // Truthy 'exit' or no 'exit' array key (default: true) means it will exit.
        return ! array_key_exists('exit', $arg) || (bool)$arg['exit'];
    }
}
