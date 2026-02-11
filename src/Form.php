<?php

declare(strict_types=1);

namespace i80586\Form;

use i80586\Form\Elements\Input;
use i80586\Form\Elements\Label;
use i80586\Form\Elements\Select;
use i80586\Form\Elements\Tag;
use i80586\Form\Elements\TextArea;

/**
 * Form element factory (singleton).
 *
 * @author Rasim Ashurov
 * @date 7 February 2026
 */
class Form
{

    public function __wakeup()
    {
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function instance(): static
    {
        static $instance;
        if (!$instance) {
            return $instance = new self();
        }
        return $instance;
    }

    /**
     * Creates a generic HTML tag element.
     *
     * If $content is false, the tag is considered self-closing (void).
     *
     * @param string $tagName Tag name (e.g. "div", "span", "a").
     * @param mixed $content Tag content. Use false for self-closing tags.
     */
    public function tag(string $tagName, mixed $content = false): Tag
    {
        return new Tag($tagName, $content);
    }

    /**
     * Creates a <label> element.
     *
     * @param string $text Label text.
     * @param string|null $for Value for the "for" attribute (usually the input id).
     */
    public function label(string $text, ?string $for = null): Label
    {
        return new Label($text, $for);
    }

    /**
     * Creates an <input> element.
     *
     * @param string $name Value for the "name" attribute.
     * @param mixed|null $value Initial value.
     */
    public function input(string $name, mixed $value = null): Input
    {
        return new Input($name, $value);
    }

    /**
     * Creates a <textarea> element.
     *
     * @param string|null $name Value for the "name" attribute.
     * @param mixed|null  $value Initial content of the textarea.
     */
    public function textarea(?string $name = null, mixed $value = null): TextArea
    {
        return new TextArea($name, $value);
    }

    /**
     * Create a <select> element.
     *
     * @param string|null $name     Value for the "name" attribute.
     * @param mixed|null $chosen    The value of the selected option.
     * @param array $list           List of options. <key-value> pairs.
     * @param string|null $prompt   Default option label without value.
     */
    public function select(?string $name = null, mixed $chosen = null, array $list = [], ?string $prompt = null): Select
    {
        return new Select($name, $chosen, $list, $prompt);
    }

    /**
     * Creates an <a> element with an optional href.
     *
     * @param string $label Link text.
     * @param string|null $link Value for the "href" attribute. If null, href is not set.
     */
    public function link(string $label, ?string $link = null): Tag
    {
        $tag = new Tag('a', $label);
        return $tag->href($link ?? false);
    }

}
