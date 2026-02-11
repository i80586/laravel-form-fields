<?php

declare(strict_types=1);

namespace i80586\Form\Elements;

/**
 * Represents an <input> form control.
 *
 * Automatically binds its value from Laravel "old" input data,
 * falling back to the provided default value.
 *
 * @author Rasim Ashurov
 * @date 7 February 2026
 */
class Input extends Element
{

    /**
     * Indicates that the element should render as a form control with label and hint.
     */
    protected bool $isFormElement = true;

    /**
     * Creates an input element.
     *
     * The input type defaults to "text".
     * When a name is provided, default attributes are initialized (name, id, label, class).
     * The input value is resolved from Laravel old() data first, then from $value.
     *
     * @param string|null $name   Field name attribute.
     * @param mixed       $value  Default input value.
     */
    public function __construct(?string $name = null, mixed $value = null)
    {
        $this->addAttribute('type', 'text');

        if ($name !== null) {
            $this->initializeDefault($name);
        }

        $actualValue = $this->getOldValue($name, $value);
        if ($actualValue !== null) {
            $this->addAttribute('value', $actualValue);
        }
    }

    /**
     * Returns the element tag name.
     */
    protected function tagName(): string
    {
        return 'input';
    }
}