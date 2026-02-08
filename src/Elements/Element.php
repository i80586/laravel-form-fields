<?php

declare(strict_types=1);

namespace i80586\Form\Elements;

use i80586\Form\Traits\Attributable;
use i80586\Form\Traits\Hintable;
use i80586\Form\Traits\Labelable;
use i80586\Form\Traits\Valuable;

abstract class Element
{

    use Attributable, Valuable, Labelable, Hintable;

    protected bool $isClosable = false;
    protected ?string $content = null;

    abstract protected function tagName(): string;

    public function render(): string
    {
        $html = $this->isClosable ? $this->makeClosableElement() : $this->makeNonClosableElement();
        if ($this->labelIsSet()) {
            $html = $this->addLabel($html);
        }
        if ($this->hintIsSet()) {
            $html = $this->addHint($html);
        }
        $this->reset();
        return $html;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    protected function initializeDefault(string $name): void
    {
        $this->addAttribute('name', $name);
        $this->addAttribute('id', $this->makeDefaultId($name));
        $this->setDefaultLabel($name);
        $this->appendClass( 'form-control');

        if ($this->isInvalid($name)) {
            $this->appendClass('is-invalid');
        }
    }

    protected function prepareName(string $name): string
    {
        $name = str_replace(['[', ']'], '.', $name);
        $name = preg_replace('/[.]+/i', '.', $name);
        return rtrim($name, '.');
    }

    protected function makeClosableElement(): string
    {
        return sprintf('<%1$s%2$s>%3$s</%1$s>',
            $this->tagName(),
            $this->convertAttributes($this->attributes),
            $this->content ?? '',
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

    protected function makeDefaultId(string $name): string
    {
        return str_replace(
            ['[]', '][', '[', ']', ' ', '.', '--'],
            ['', '_', '_', '', '_', '_', '_'],
            $name
        );
    }

    private function addLabel(string $html): string
    {
        $label = new Label($this->label, $this->attributes['id'] ?? null);
        return $label . $html;
    }

    private function addHint(string $html): string
    {
        $html .= $this->hint;
        return $html;
    }

}