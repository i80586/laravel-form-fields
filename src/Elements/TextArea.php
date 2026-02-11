<?php

declare(strict_types=1);

namespace i80586\Form\Elements;

/**
 * Represents a <textarea> form control.
 *
 * Automatically binds its value from Laravel "old" input data,
 * falling back to the provided default value.
 *
 * @author Rasim Ashurov
 * @date 8 February 2026
 */
class TextArea extends Element
{

    /**
     * Indicates that the element should render as a form control with label and hint.
     */
    protected bool $isFormElement = true;

    /**
     * Creates a textarea element.
     *
     * When a name is provided, default attributes are initialized (name, id, label, class).
     * The textarea content is resolved from Laravel old() data first, then from $value.
     *
     * @param string|null $name   Field name attribute.
     * @param mixed       $value  Default textarea content.
     */
    public function __construct(?string $name = null, mixed $value = null)
    {
        if ($name !== null) {
            $this->initializeDefault($name);

            $actualValue = $this->getOldValue($name, $value);
            if ($actualValue !== null) {
                $this->setContent($actualValue);
            }
        }
    }

    /**
     * Returns the element tag name.
     */
    protected function tagName(): string
    {
        return 'textarea';
    }

}