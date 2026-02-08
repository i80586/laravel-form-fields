<?php

declare(strict_types=1);

namespace i80586\Form\Elements;

class Tag extends Element
{

    public function __construct(private readonly string $tagName, mixed $content = false)
    {
        if ($content !== false) {
            $this->content = $content;
            $this->isClosable = true;
        }
    }

    protected function tagName(): string
    {
        return $this->tagName;
    }
}