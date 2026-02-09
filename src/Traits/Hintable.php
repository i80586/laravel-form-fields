<?php

declare(strict_types=1);

namespace i80586\Form\Traits;

/**
 * Adds validation hint support to form elements.
 *
 * Integrates with Laravel's validation error bag.
 *
 * @author Rasim Ashurov
 * @date 7 February 2026
 */
trait Hintable
{

    /**
     * Stores the validation hint message.
     */
    private ?string $hint = null;

    /**
     * Indicates whether hints should be rendered.
     */
    private bool $withHint = false;

    /**
     * Enables rendering of validation hints.
     */
    public function withHint(): static
    {
        $this->withHint = true;
        return $this;
    }

    /**
     * Checks whether the field is invalid and extracts the validation message.
     *
     * The field name is normalized to dot notation before lookup in the error bag.
     * When an error exists, the first validation message is stored as a hint.
     *
     * @param string $name Field name.
     */
    protected function isInvalid(string $name): bool
    {
        $name = $this->prepareName($name);
        $errors = \View::getShared()['errors'] ?? null;

        if ($errors !== null && $errors->has($name)) {
            $this->hint = $errors->first($name);
            return true;
        }

        return false;
    }

    /**
     * Determines whether a validation hint should be rendered.
     */
    protected function hintIsSet(): bool
    {
        return $this->withHint;
    }

}