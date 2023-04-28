<?php

declare(strict_types = 1);

namespace PhpStubs\WordPress\Reflection\DocBlock\Tag;

require_once(__DIR__ . '/vendor/autoload.php');

use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\DocBlock\Tags\BaseTag;
use phpDocumentor\Reflection\Types\Context;
use Webmozart\Assert\Assert;

final class Access extends BaseTag
{
    protected $name = 'access';

    public function __construct(Description $description = null)
    {
        $this->description = $description;
    }

    public static function create(string $body, DescriptionFactory $descriptionFactory = null, ?Context $context = null): self
    {
        Assert::notNull($descriptionFactory);
        return new static($descriptionFactory->create($body, $context));
    }

    public function __toString(): string
    {
        return (string)$this->description;
    }
}

$factory = DocBlockFactory::createInstance(['access' => Access::class]);
