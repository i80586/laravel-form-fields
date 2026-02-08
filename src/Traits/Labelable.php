<?php

namespace i80586\Form\Traits;

trait Labelable
{

    protected ?string $label = null;

    public function label(string|false $label): static
    {
        $this->label = $label === false ? null : $label;
        return $this;
    }

    protected function setDefaultLabel(string $name): void
    {
        $name        = str_replace('_', ' ', $name);
        $this->label = ucfirst($name);
    }

    protected function labelIsSet(): bool
    {
        return $this->label !== null;
    }

}