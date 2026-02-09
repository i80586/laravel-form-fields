<?php

declare(strict_types=1);

namespace i80586\Form\Elements;

/**
 * Represents an HTML <label> element.
 *
 * @author Rasim Ashurov
 * @date 8 February 2026
 */
class Label extends Element
{

    /**
     * Creates a label element.
     *
     * The label text is rendered as the element content.
     * When provided, the "for" attribute is used to associate the label
     * with a form control by its id.
     *
     * @param string      $label Label text.
     * @param string|null $for   Value for the "for" attribute.
     */
    public function __construct(string $label, ?string $for = null)
    {
        $this->setContent($label);
        if ($for !== null) {
            $this->addAttribute('for', $for);
        }
    }

    /**
     * Returns the element tag name.
     */
    protected function tagName(): string
    {
        return 'label';
    }
}