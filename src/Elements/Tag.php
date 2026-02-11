<?php

declare(strict_types=1);

namespace i80586\Form\Elements;

/**
 * Represents a generic HTML tag.
 *
 * Can be used to render both void and non-void HTML elements.
 *
 * @author Rasim Ashurov
 * @date 8 February 2026
 */
class Tag extends Element
{

    /**
     * Creates a generic HTML tag.
     *
     * When $content is false, the tag is treated as a void element
     * and rendered without a closing tag.
     * When $content is null or a string, the tag is rendered with
     * opening and closing tags.
     *
     * @param string $tagName  HTML tag name.
     * @param mixed  $content  Tag content or false to create a void tag.
     */
    public function __construct(private readonly string $tagName, mixed $content = false)
    {
        if ($content !== false) {
            $this->content    = $content ?? '';
        }
    }

    /**
     * Returns the element tag name.
     */
    protected function tagName(): string
    {
        return $this->tagName;
    }
}