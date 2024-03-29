<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Traits\DisabledTrait;

class WYSIWYG extends Field
{
    use DisabledTrait;

    private array $settings = [];

    private ?int $width = null;

    private ?int $height = null;

    public function output($currentValue, array $args = []): string
    {
        ob_start();

        $styleTag = $this->getWidth() === null ? '' : <<<HTML
            <style>
                #wp-{$this->getId()}-editor-container, #wp-{$this->getId()}-editor-tools {
                    width: {$this->getWidth()}px;
                }
            </style>
        HTML;

        $editorSettings = $this->getSettings();

        if ($this->getHeight() !== null) {
            $editorSettings['editor_height'] = $this->getHeight();
        }

        $editorSettings['readonly'] = $this->isDisabled();

        $is_disabled = $this->isDisabled();

        $tiny_mce_before_init = static function ($args) use ($is_disabled) {
            if ($is_disabled) {
                $args['readonly'] = 1;
            }

            return $args;
        };

        add_filter('tiny_mce_before_init', $tiny_mce_before_init);

        echo $styleTag;
        wp_editor($currentValue, $this->getId(), $editorSettings);

        remove_filter('tiny_mce_before_init', $tiny_mce_before_init);

        return ob_get_clean();
    }

    /**
     * @return int
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return WYSIWYG
     */
    public function setWidth(int $width): WYSIWYG
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * @param array $settings
     * @return WYSIWYG
     */
    public function setSettings(array $settings): WYSIWYG
    {
        $this->settings = $settings;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @param int $height
     * @return WYSIWYG
     */
    public function setHeight(int $height): WYSIWYG
    {
        $this->height = $height;
        return $this;
    }
}
