<?php

declare(strict_types=1);

namespace i80586\Form\Traits;

use i80586\Form\Elements\Tag;

trait Hintable
{

    private ?string $errorLabel = null;
    private ?string $hint = null;

    public function withHint(): static
    {
        if ($this->errorLabel !== null) {
            $hint = new Tag('p', $this->errorLabel);
            $hint->class('text-danger');

            $this->hint = $hint->render();
        }
        return $this;
    }

    protected function isInvalid(string $name): bool
    {
        $name = $this->prepareName($name);
        $errors = \View::getShared()['errors'] ?? null; // Laravel View class

        if ($errors !== null && $errors->has($name)) {
            $this->errorLabel = $errors->first($name);
            return true;
        }

        return false;
    }

    protected function hintIsSet(): bool
    {
        return $this->hint !== null;
    }

}