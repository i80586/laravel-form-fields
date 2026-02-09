<?php

declare(strict_types=1);

namespace i80586\Form\Elements;

/**
 * Represents a <select> form control.
 *
 * Supports option groups and Laravel "old" value binding via the base element traits.
 *
 * @date 9 February 2026
 */
class Select extends Element
{

    /**
     * Indicates that the element should render as a form control with label and hint.
     */
    protected bool $isFormElement = true;

    /**
     * Stores an optional prompt label rendered as the first empty option.
     */
    protected ?string $prompt = null;

    /**
     * Creates a select element and generates its options.
     *
     * When a name is provided, default attributes are initialized (name, id, label, class).
     * The selected value is resolved from Laravel old() data first, falling back to $chosen.
     *
     * The $list may contain nested arrays to define <optgroup> blocks:
     * [
     *   'Group label' => ['1' => 'One', '2' => 'Two'],
     *   '3' => 'Three',
     * ]
     *
     * @param string|null $name    Field name attribute.
     * @param mixed       $chosen  Default selected value.
     * @param array       $list    Options map or grouped options.
     * @param string|null $prompt  Prompt label rendered as an empty option.
     */
    public function __construct(?string $name = null, mixed $chosen = null, array $list = [], ?string $prompt = null)
    {
        if ($name !== null) {
            $this->initializeDefault($name);
        }

        $this->prompt($prompt);

        $actualValue = $this->getOldValue($name, $chosen);
        $options     = $this->generateContent($list, $actualValue);
        $this->setContent($options);
    }

    /**
     * Sets a prompt label rendered as the first empty option.
     *
     * @param string $label Prompt text.
     */
    public function prompt(string $label): self
    {
        $this->prompt = $label;
        return $this;
    }

    /**
     * Returns the element tag name.
     */
    protected function tagName(): string
    {
        return 'select';
    }

    /**
     * Generates HTML content for the select element.
     *
     * @param array $list     Options map or grouped options.
     * @param mixed $chosen   Selected value.
     */
    private function generateContent(array $list, mixed $chosen = null): string
    {
        $content = '';

        if ($this->prompt !== null) {
            $option = new Tag('option', $this->prompt);
            $option->value();
            $content = $option->render();
        }

        $selectedSet = $this->normalizeChosen($chosen);
        $content .= $this->renderOptions($list, $selectedSet);

        return $content;
    }

    /**
     * Renders options and option groups recursively.
     *
     * @param array $list          Options map or grouped options.
     * @param array $selectedSet   Selected value set in the form ['value' => true].
     */
    private function renderOptions(array $list, array $selectedSet): string
    {
        $options = '';
        foreach ($list as $value => $labelOrGroup) {
            if (is_array($labelOrGroup)) {
                $optionGroup = new Tag('optgroup', $this->renderOptions($labelOrGroup, $selectedSet));
                $optionGroup->label($value);

                $options .= $optionGroup->render();
                continue;
            }

            $options .= $this->renderOption($labelOrGroup, $value, $selectedSet);
        }
        return $options;
    }

    /**
     * Renders a single <option> tag.
     *
     * @param string $label        Option label.
     * @param mixed  $value        Option value.
     * @param array  $selectedSet  Selected value set in the form ['value' => true].
     */
    private function renderOption(string $label, mixed $value, array $selectedSet): string
    {
        $option = new Tag('option', $label);

        $valueStr = (string)$value;

        if ($valueStr !== '') {
            $option->value($value);
        }

        if (isset($selectedSet[$valueStr])) {
            $option->selected();
        }

        return $option->render();
    }

    /**
     * Normalizes the selected value into a lookup set.
     *
     * @param mixed $chosen Selected value.
     *
     * @return array<string, bool>
     */
    private function normalizeChosen(mixed $chosen): array
    {
        if ($chosen === null) {
            return [];
        }

        return [(string)$chosen => true];
    }

}