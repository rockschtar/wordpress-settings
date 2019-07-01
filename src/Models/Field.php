<?php

namespace Rockschtar\WordPress\Settings\Models;

use InvalidArgumentException;

/**
 * Class Field
 * @package Rockschtar\WordPress\Settings
 */
abstract class Field {

    /**
     * @var string
     */
    private $label = '';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var array
     */
    private $arguments = [];

    /**
     * @var mixed|null
     */
    private $default_option;

    /**
     * @var mixed|null
     */
    private $override_option;

    /**
     * @var bool
     */
    private $disabled = false;

    /**
     * @var bool
     */
    private $readonly = false;

    /**
     * @var callable
     */
    private $sanitize_callback;

    /**
     * @var String[]
     */
    private $css_classes = [];

    /**
     * @var Asset[]
     */
    private $assets = [];

    /**
     * @return bool
     */
    public function isDisabled(): bool {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     * @return static
     */
    public function setDisabled(bool $disabled) {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * Field constructor.
     * @param $id
     */
    public function __construct($id) {
        $this->setId($id);
    }

    /**
     * @param string $id
     * @return static
     */
    public static function create(string $id) {
        $class = static::class;
        return new $class($id);
    }

    /**
     * @return mixed
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return static
     */
    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return static
     * @throws InvalidArgumentException
     */
    public function setId($id) {

        $validate = preg_match_all('/^[a-zA-Z0-9_-]+$/i', $id, $result) === 1;

        if (!$validate) {
            throw new InvalidArgumentException('Id ' . $id . ' is invalid or missing. Allowed characters: A-Z, a-z, 0-9, _ and - ');
        }

        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @param string $description
     * @return static
     */
    public function setDescription(string $description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array
     */
    public function getArguments(): array {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     * @return static
     */
    public function setArguments(array $arguments) {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    final public function output($current_value, array $args = []): string {
        $output = apply_filters('rwps_field_html', $this->inputHTML($current_value, $args), $this->getId());
        if (!empty($this->getDescription())) {
            $output .= sprintf('<p class="description">%s</p>', $this->getDescription());

        }
        $output = apply_filters('rwps_field', $output, $this->getId());
        $output = apply_filters('rwps_field-' . $this->getId(), $output);

        return $output;
    }

    /**
     * @return mixed|null
     */
    public function getDefaultOption() {
        return $this->default_option;
    }

    /**
     * @param mixed $default_option
     * @return static
     */
    public function setDefaultOption($default_option) {
        $this->default_option = $default_option;

        add_filter('default_option_' . $this->getId(), static function ($default) use ($default_option) {

            if ($default === false) {
                return $default_option;
            }

            return $default;

        }, 10, 1);

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getOverrideOption() {
        return $this->override_option;
    }

    /**
     * @param mixed|null $override_option
     * @return static
     */
    public function setOverrideOption($override_option) {
        $this->override_option = $override_option;

        $filter = static function () use ($override_option) {
            return $override_option;
        };

        remove_filter('option_' . $this->getId(), $filter);
        add_filter('option_' . $this->getId(), $filter);

        return $this;
    }

    /**
     * @return callable|null
     */
    public function getSanitizeCallback(): ?callable {
        return $this->sanitize_callback;
    }

    /**
     * @param callable $sanitize_callback
     * @return static
     */
    public function setSanitizeCallback(callable $sanitize_callback) {
        $this->sanitize_callback = $sanitize_callback;
        return $this;
    }

    /**
     * @return bool
     */
    public function isReadonly(): bool {
        return $this->readonly;
    }

    /**
     * @param bool $readonly
     * @return static
     */
    public function setReadonly(bool $readonly) {
        $this->readonly = $readonly;
        return $this;
    }

    /**
     * @return Asset[]
     */
    public function getAssets(): array {
        return $this->assets;
    }

    /**
     * @param Asset[] $assets
     * @return Field
     */
    public function setAssets(array $assets): Field {
        $this->assets = $assets;
        return $this;
    }

    /**
     * @param Asset $asset
     * @return Field
     */
    public function addAsset(Asset $asset): Field {
        $this->assets[] = $asset;
        return $this;
    }

    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    abstract public function inputHTML($current_value, array $args = []): string;

    /**
     * @param $current_value
     * @return HTMLTag
     */
    public function getHTMLTag($current_value): HTMLTag {
        $html_tag = new HTMLTag('input');
        $html_tag->setAttribute('type', 'text');

        $html_tag->setAttribute('id', $this->getId());
        $html_tag->setAttribute('name', $this->getId());

        if ($this->isReadonly()) {
            $html_tag->setAttribute('readonly');
        }

        if ($this->isDisabled()) {
            $html_tag->setAttribute('disabled');
        }

        $html_tag->setAttribute('value', $current_value);
        return apply_filters('rwps_html_tag', $html_tag, $this->getId());
    }

    /**
     * @return String[]
     */
    public function getCssClasses(): array {
        $this->css_classes = apply_filters('rwps_field_css_classes', $this->css_classes, $this->getId());
        $this->css_classes = apply_filters('rwps_field_css_classes-' . $this->getId(), $this->css_classes);
        return $this->css_classes;
    }

    /**
     * @param string $css_class
     * @return static
     */
    public function addCssClass(string $css_class) {
        $this->css_classes[] = $css_class;
        return $this;
    }

    /**
     * @return String[]
     */
    public function getCssClassesAsString(): string {
        return implode(', ', $this->css_classes);
    }

    /**
     * @param String[] $css_classes
     * @return Field
     */
    public function setCssClasses(array $css_classes): Field {
        $this->css_classes = $css_classes;
        return $this;
    }
}