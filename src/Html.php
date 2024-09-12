<?php
declare(strict_types=1);

namespace i80586\Form;

/**
 * @author Rasim Ashurov
 * @date 6 April, 2022
 */
class Html
{

    private static self $instance;

    public function __wakeup()
    {
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function instance(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Generates HTML tag, adds attributes (via $options parameter) and content (optional).
     *
     * @param string    $tagName            Tag name. Example: 'div', 'span', 'p', 'a', etc.
     * @param mixed     $content (optional) Tag content. If false, tag will be self-closing.
     * @param array     $options (optional) Tag attributes. Example: ['class' => 'text-center', 'id' => 'my-id'].
     *
     * @return string
     */
    public function tag(string $tagName, mixed $content = false, array $options = []): string
    {
        if ($content === false) {
            return sprintf('<%s%s>', $tagName, self::generateHtmlOptionsToString($options));
        }
        return sprintf('<%s%s>%s</%s>', $tagName, self::generateHtmlOptionsToString($options), $content, $tagName);
    }

    /**
     * Generates <label $options>$text</label> tag.
     *
     * @param string        $text               Text content between tag pairs.
     * @param string|null   $for (optional)     The value of the 'for' attribute. If not provided will not be added.
     * @param array         $options (optional) Tag attributes. Example: ['class' => 'class names here', 'id' => 'my-custom-id'].
     *
     * @return string
     */
    public function label(string $text, ?string $for = null, array $options = []): string
    {
        if (!empty($for)) {
            $options['for'] = $for;
        }
        return $this->tag('label', $text, $options);
    }

    /**
     * Generates <input $options> tag.
     *
     * @param string    $name               The 'name' attribute.
     * @param mixed     $value              The 'value' attribute.
     * @param array     $options (optional) Tag attributes. Example: ['class' => 'class names here', 'id' => 'my-custom-id'].
     * @param string    $type (optional)    The value of the 'type' attribute.
     *
     * @return string
     */
    public function input(string $name, mixed $value = null, array $options = [], string $type = 'text'): string
    {
        $options['class'] = self::classNameWithError($name, $options['class'] ?? 'form-control');
        $options['value'] = $this->getOldValue($name, $value);
        if (is_null($options['value'])) {
            unset($options['value']);
        } elseif (is_string($options['value'])) {
            $options['value'] = htmlspecialchars($options['value']);
        }
        $options['id']    = $options['id'] ?? $name;
        $options['name']  = $name;
        $options['type']  = $type;

        if (empty($options['class'])) {
            unset($options['class']);
        }

        $html  = $this->appendLabelIfNeeded($name, $options);
        $label = $this->appendErrorLabelIfNeeded($options);

        $html .= sprintf('<input%s>', self::generateHtmlOptionsToString(array_reverse($options)));
        $html .= $label;

        return $html;
    }

    /**
     * Generates <textarea $options>$value</textarea> tag.
     *
     * @param string    $name               The 'name' attribute.
     * @param mixed     $value (optional)   The content between tag pairs.
     * @param array     $options (optional) Tag attributes. Example: ['class' => 'class names here', 'id' => 'my-custom-id'].
     *
     * @return string
     */
    public function textarea(string $name, mixed $value = null, array $options = []): string
    {
        $options['class'] = self::classNameWithError($name, $options['class'] ?? 'form-control');
        $options['id']    = $options['id'] ?? $name;
        $options['name']  = $name;

        if (empty($options['class'])) {
            unset($options['class']);
        }

        $html  = $this->appendLabelIfNeeded($name, $options);
        $label = $this->appendErrorLabelIfNeeded($options);

        $html .= sprintf('<textarea%s>%s</textarea>',
            self::generateHtmlOptionsToString(array_reverse($options)),
            $this->getOldValue($name, $value)
        );
        $html .= $label;

        return $html;
    }

    /**
     * Generates <select $options>$optionsList</select> tag.
     *
     * @param string    $name               The 'name' attribute.
     * @param mixed     $chosen (optional)  The 'selected' attribute.
     * @param array     $list (optional)    The list of options. Example: ['value' => 'key', 'value2' => 'key2'].
     * @param array     $options (optional) Tag attributes. Example: ['class' => 'class names here', 'id' => 'my-custom-id'].
     *
     * @return string
     */
    public function dropDown(string $name, mixed $chosen = null, array $list = [], array $options = []): string
    {
        $optionsList = [];
        if (!empty($options['prompt'])) {
            $optionsList[] = $this->tag('option', $options['prompt'], ['value' => null]);
            unset($options['prompt']);
        }
        foreach ($list as $value => $key) {
            $htmlOptions = [];
            if ((string)$value !== '') {
                $htmlOptions = ['value' => $value];
            }
            $oldValue = $this->getOldValue($name, $chosen);
            if (
                (is_scalar($oldValue) && $value == $oldValue) ||
                (is_array($oldValue) && in_array($value, $oldValue))
            ) {
                $htmlOptions['selected'] = true;
            }
            $optionsList[] = $this->tag('option', $key, $htmlOptions);
        }

        $options['class'] = self::classNameWithError($name, $options['class'] ?? 'form-control');
        if (empty($options['class'])) {
            unset($options['class']);
        }

        $html  = $this->appendLabelIfNeeded($name, $options);
        $label = $this->appendErrorLabelIfNeeded($options);

        $html .= $this->tag('select', implode('', $optionsList), array_merge([
            'name' => $name,
            'id'   => $options['id'] ?? $name
        ], $options));
        $html .= $label;

        return $html;
    }

    /**
     * Appends checkbox with label for AdminLte admin panel
     *
     * @param string    $label   The label for checkbox
     * @param string    $name    The content between tag pairs
     * @param bool|null $checked Flag whether checkbox is checked or not
     * @param array     $options (optional) Tag attributes.
     *
     * @return string
     */
    public function checkbox(string $label, string $name, bool|int|null $checked, array $options = []): string
    {
        $html = $this->label($label, $name);
        $html .= $this->tag('label',
            $this->input($name, null,
                ['checked' => $this->getOldValue($name, $checked), 'label' => false], 'checkbox')
            . $this->tag('span', '', array_merge($options, ['class' => 'slider round'])),
            ['class' => 'switch']);
        return $html;
    }

    /**
     * Appends label tag under some conditions.
     *
     * @param string    $name               The content between tag pairs.
     * @param array     $options (optional) Tag attributes. Example: ['label' => 'email'].
     *
     * @return string
     */
    protected function appendLabelIfNeeded(string $name, array &$options): string
    {
        $html = '';
        if (!isset($options['label'])) {
            $html .= $this->label(ucfirst($name), $name);
        } elseif ($options['label'] !== false) {
            $html .= $this->label($options['label'], $name);
        }
        unset($options['label']);
        return $html;
    }

    /**
     * Appends error label under some conditions
     *
     * @param array     $options Tag attributes. Example: ['errorLabel' => 'This field is required', 'class' => 'is-invalid'].
     *
     * @return string
     */
    protected function appendErrorLabelIfNeeded(array &$options): string
    {
        $label = '';
        if (!empty($options['errorLabel']) && str_contains($options['class'], 'is-invalid')) {
            $label = $this->tag('span', $options['errorLabel'], ['class' => 'text-danger']);
            unset($options['errorLabel']);
        }
        return $label;
    }

    /**
     * Returns old value from the previous request.
     *
     * @param string    $name                       The 'name' attribute.
     * @param mixed     $defaultValue (optional)    The default value.
     *
     * @return mixed
     */
    protected function getOldValue(string $name, mixed $defaultValue = null): mixed
    {
        $name = str_replace(['[', ']'], '.', $name);
        $name = rtrim(preg_replace('/[\.]+/i', '.', $name), '.');
        return old($name, $defaultValue); // Laravel helper function
    }

    /**
     * Adds 'is-invalid' class to the input if there is an error.
     *
     * @param string               $fieldName      The 'name' attribute.
     * @param string|false|null    $classNames     The 'class' attribute.
     *
     * @return string
     */
    protected static function classNameWithError(string $fieldName, string|false|null $classNames): string
    {
        if (empty($classNames)) {
            $classNames = '';
        }
        $fieldName = self::getInputIdByName($fieldName);
        $errors = \View::getShared()['errors'] ?? null; // Laravel View class
        if (!is_null($errors) && $errors->has($fieldName)) {
            $classNames .= ' is-invalid';
        }
        return $classNames;
    }

    /**
     * Generates tag attributes from key => value based options
     *
     * @param array     $options Tag attributes. Example: ['class' => 'class names here', 'id' => 'my-custom-id'].
     *
     * @return string
     */
    protected static function generateHtmlOptionsToString(array $options): string
    {
        $htmlOptionsAsString = join(' ', array_map(function ($key) use ($options) {
            if (is_bool($options[$key])) {
                return $options[$key] ? $key : '';
            }
            return $key . '="' . $options[$key] . '"';
        }, array_keys($options)));
        if (!empty($htmlOptionsAsString)) {
            $htmlOptionsAsString = ' ' . $htmlOptionsAsString;
        }
        return $htmlOptionsAsString;
    }

    /**
     * Converts array-like input name to dot notation
     *
     * @param string    $fieldName The 'name' attribute.
     *
     * @return string
     */
    protected static function getInputIdByName(string $fieldName): string
    {
        return str_replace(['[]', '][', '[', ']', ' ', '.', '--'], ['', '.', '.', '', '.', '.', '.'], $fieldName);
    }

}
