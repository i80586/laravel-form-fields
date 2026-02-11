<?php

namespace i80586\Form\Traits;

/**
 * Adds label handling capabilities to an element.
 *
 * @author Rasim Ashurov
 * @date 8 February 2026
 */
trait Labelable
{

    /**
     * Stores the label text.
     */
    protected ?string $label = null;

    /**
     * Sets or removes the label.
     *
     * For form elements, the label text is stored internally and rendered as a
     * separate <label> element. For non-form elements, the label is added as a
     * regular HTML attribute.
     *
     * Passing false removes the label for form elements.
     *
     * @param string|false $label Label text or false to remove it.
     */
    public function label(string|false $label): static
    {
        if ($this->isFormElement) {
            $this->label = $label === false ? null : $label;
        } else {
            $this->addAttribute('label', $label);
        }
        return $this;
    }

    /**
     * Sets a default label based on the element name.
     *
     * Underscores are replaced with spaces and the first character is capitalized.
     *
     * @param string $name Element name.
     */
    protected function setDefaultLabel(string $name): void
    {
        $name        = str_replace('_', ' ', $name);
        $this->label = ucfirst($name);
    }

    /**
     * Removes the label.
     */
    protected function removeLabel(): void
    {
        $this->label = null;
    }

    /**
     * Determines whether a label is set.
     */
    protected function labelIsSet(): bool
    {
        return $this->label !== null;
    }

}