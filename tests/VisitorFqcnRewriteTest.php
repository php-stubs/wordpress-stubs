<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use org\bovigo\vfs\vfsStream;
use PhpStubs\WordPress\Core\Visitor;
use PHPUnit\Framework\TestCase;
use StubsGenerator\Finder;
use StubsGenerator\StubsGenerator;

// phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength

final class VisitorFqcnRewriteTest extends TestCase
{
    public function testImportedNamesAreRewrittenInDocTags(): void
    {
        $source = <<<'PHP'
        <?php

        declare(strict_types=1);

        namespace Acme\Builders;

        use Acme\Models\Message;
        use Acme\Models\ProviderRegistry as Registry;
        use Acme\Exceptions\InvalidArgumentException;

        class PromptBuilder
        {
            /**
             * @var list<Message> The collected messages.
             */
            protected array $messages = [];

            /**
             * @param Message  $message  The message to add.
             * @param Registry $registry The registry (aliased import).
             * @return Message
             * @throws InvalidArgumentException When invalid.
             */
            public function add(Message $message, Registry $registry): Message
            {
                return $message;
            }

            /**
             * @param Message ...$parts The parts.
             * @return self
             */
            public function withParts(Message ...$parts): self
            {
                return $this;
            }
        }
        PHP;

        $output = $this->generateStubs($source);

        // Tags are rewritten to fully qualified names.
        self::assertStringContainsString('@var list<\Acme\Models\Message>', $output);
        self::assertStringContainsString('@param \Acme\Models\Message  $message', $output);
        self::assertStringContainsString('@param \Acme\Models\ProviderRegistry $registry', $output);
        self::assertStringContainsString('@return \Acme\Models\Message', $output);
        self::assertStringContainsString('@throws \Acme\Exceptions\InvalidArgumentException When invalid.', $output);
        self::assertStringContainsString('@param \Acme\Models\Message ...$parts', $output);

        // Unqualified names no longer appear in the output.
        self::assertStringNotContainsString('@param Message ', $output);
        self::assertStringNotContainsString('@param Registry ', $output);
        self::assertStringNotContainsString('@throws InvalidArgumentException', $output);
        self::assertStringNotContainsString('@var list<Message>', $output);

        // Type declarations are rewritten to fully qualified names.
        self::assertStringContainsString('public function add(\Acme\Models\Message $message', $output);

        // Imports no longer appear in the output.
        self::assertStringNotContainsString('use Acme\Models\Message', $output);

        // Descriptions are preserved verbatim.
        self::assertStringContainsString('The registry (aliased import).', $output);
    }

    public function testShapeKeysConstantsAndTemplatesAreHandled(): void
    {
        $source = <<<'PHP'
        <?php

        declare(strict_types=1);

        namespace Acme\Lib;

        use Acme\Models\Status;
        use Acme\Models\Reply;

        class Handler
        {
            /**
             * @template Reply
             * @param Reply $x The item (Reply is a template here, not the import).
             * @param array{status: int, extra: Status} $opts The options.
             * @return Status::ACTIVE
             */
            public function run($x, array $opts)
            {
                return \Acme\Models\Status::ACTIVE;
            }
        }
        PHP;

        $output = $this->generateStubs($source);

        // Template names are preserved verbatim, even if they match an import.
        self::assertStringContainsString('@param Reply $x', $output);
        self::assertStringNotContainsString('@param \Acme\Models\Reply $x', $output);

        // Shape keys are preserved verbatim, even if they match an import.
        self::assertStringContainsString('status: int', $output);
        self::assertStringContainsString('extra: \Acme\Models\Status', $output);
        self::assertStringNotContainsString('\Acme\Models\Status: int', $output);

        // Return types that reference constants are rewritten to fully qualified names.
        self::assertStringContainsString('@return \Acme\Models\Status::ACTIVE', $output);
    }

    private function generateStubs(string $source): string
    {
        $root = vfsStream::setup('stubs');
        vfsStream::newFile('fixture.php')->at($root)->setContent($source);

        $finder = Finder::create()->in(vfsStream::url('stubs'))->name('*.php');
        return (new StubsGenerator())->generate($finder, new Visitor())->prettyPrint();
    }
}
