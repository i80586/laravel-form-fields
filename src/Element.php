<?php

declare(strict_types=1);

namespace i80586\Form;

abstract class Element
{

    use Attributable;

    abstract protected function tagName(): string;
    abstract protected function isClosable(): bool;

    public function render(): string
    {
        $html = $this->isClosable() ? $this->makeClosableElement() : $this->makeNonClosableElement();
        $this->reset();
        return $html;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    protected function makeClosableElement(): string
    {
        return sprintf('<%1$s%2$s></%1$s>',
            $this->tagName(),
            $this->convertAttributes($this->attributes)
        );
    }

    protected function makeNonClosableElement(): string
    {
        return sprintf('<%s%s>',
            $this->tagName(),
            $this->convertAttributes($this->attributes)
        );
    }

    protected function reset(): void
    {
        $this->resetAttributes();
    }

    protected function convertNameToId(string $name): string
    {
        return str_replace(
            ['[]', '][', '[', ']', ' ', '.', '--'],
            ['', '_', '_', '', '_', '_', '_'],
            $name
        );
    }

}