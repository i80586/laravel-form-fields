<?php

declare(strict_types=1);

namespace i80586\Form\Elements;

class Label extends Element
{

    public function __construct(string $label, ?string $for = null)
    {
        $this->isClosable = true;
        $this->setContent($label);
        if ($for !== null) {
            $this->addAttribute('for', $for);
        }
    }

    protected function tagName(): string
    {
        return 'label';
    }
}