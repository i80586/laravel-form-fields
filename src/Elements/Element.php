<?php

declare(strict_types=1);

namespace i80586\Form\Elements;

use i80586\Form\Traits\{
    Attributable,
    Hintable,
    Labelable,
    Valuable
};

/**
 * Defines base behavior for all form elements.
 *
 * @author Rasim Ashurov
 * @date 7 February 2026
 */
abstract class Element
{

    use Attributable, Valuable, Labelable, Hintable;

    /**
     * Indicates whether the element should render as a form control with label and hint.
     */
    protected bool $isFormElement = false;

    /**
     * Stores inner HTML content for non-void elements.
     */
    protected ?string $content = null;

    /**
     * Returns the HTML tag name of the element.
     */
    abstract protected function tagName(): string;

    /**
     * Hook executed before the element is rendered.
     *
     * This method allows concrete elements to mutate their internal state,
     * attributes or content before generating the final HTML output.
     *
     * It is called automatically during the rendering lifecycle.
     */
    abstract protected function beforeRender(): void;

    /**
     * Renders the element to HTML.
     *
     * If the element is a form control, it may prepend a label and append a hint.
     * When the element is marked invalid, the "is-invalid" CSS class is appended.
     */
    public function render(): string
    {
        $this->beforeRender();

        if (!$this->isFormElement) {
            $html = $this->generate();
            $this->reset();
            return $html;
        }

        $this->applyInvalidClassIfNeeded();

        $label = $this->getLabel();
        $hint  = $this->getHint();
        $input = $this->generate();

        $this->reset();

        return $label . $input . $hint;
    }

    /**
     * Renders the element as a string.
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Sets the element inner content.
     *
     * Passing null results in a void-style tag output (no closing tag).
     *
     * @param string|null $content Inner HTML content.
     */
    protected function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * Applies default attributes for a form control.
     *
     * Sets "name", generates a default "id", sets a default label, and assigns a
     * Bootstrap-like CSS class based on the tag type.
     *
     * @param string $name Element name.
     */
    protected function initializeDefault(string $name): void
    {
        $this->addAttribute('name', $name);
        $this->addAttribute('id', $this->makeDefaultId($name));
        $this->setDefaultLabel($name);
        $this->addAttribute('class', $this->tagName() == 'select' ? 'form-select' : 'form-control');
    }

    /**
     * Normalizes a field name into dot notation.
     *
     * Example: "user[address][city]" becomes "user.address.city".
     *
     * @param string $name Raw name.
     */
    protected function prepareName(string $name): string
    {
        $name = str_replace(['[', ']'], '.', $name);
        $name = preg_replace('/[.]+/i', '.', $name);
        return rtrim($name, '.');
    }

    /**
     * Generates the HTML tag with its attributes and optional content.
     *
     * If content is null, a void-style tag is generated (no closing tag).
     */
    protected function generate(): string
    {
        $tagName    = $this->tagName();
        $attributes = $this->buildAttributesString();
        $template   = "<$tagName{$attributes}>";

        if ($this->content !== null) {
            $template .= "{$this->content}</{$tagName}>";
        }

        return $template;
    }

    /**
     * Resets element state after rendering.
     */
    protected function reset(): void
    {
        $this->content = null;
        $this->resetAttributes();
    }

    protected function suitableToCheckOld(): bool
    {
        return $this->withOldValue() && $this->hasAttribute('name');
    }

    /**
     * Builds a default HTML id from the provided name.
     *
     * @param string $name Element name.
     */
    protected function makeDefaultId(string $name): string
    {
        $name = str_replace(['][', '[', ']'], ['_', '_', ''], $name);
        $name = preg_replace('/-+/', '_', $name) ?? $name;

        return rtrim($name, '-');
    }

    /**
     * Builds a label element when label text is configured.
     */
    private function getLabel(): ?Label
    {
        if (!$this->labelIsSet()) {
            return null;
        }
        return new Label($this->label, $this->attributes['id'] ?? null);
    }

    /**
     * Builds a hint element when hint text is configured.
     */
    private function getHint(): ?Tag
    {
        if (!$this->hintIsSet()) {
            return null;
        }
        $hint = new Tag('span', $this->hint);
        return $hint->class('text-danger');
    }

    /**
     * Appends is-invalid bootstrap class if a validation error exists for this attribute
     */
    private function applyInvalidClassIfNeeded(): void
    {
        if ($this->hasAttribute('name') && $this->isInvalid($this->attributes['name'])) {
            $this->appendClass('is-invalid');
        }
    }

}