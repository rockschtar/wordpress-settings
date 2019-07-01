<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;

/**
 * Class WYSIWYG
 * @package Rockschtar\WordPress\Settings
 */
class WYSIWYG extends Field {

    use DisabledTrait;

    /**
     * @var array
     */
    private $settings = [];

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {
        ?>
        <?php
        /** @noinspection IsEmptyFunctionUsageInspection */
        if (!empty($this->getWidth())): ?>
            <!--suppress CssUnusedSymbol -->
            <style type="text/css">
                #wp-<?php echo $this->getId(); ?>-editor-container, #wp-<?php echo $this->getId(); ?>-editor-tools {
                    width: <?php echo $this->getWidth(); ?>px;
                }
            </style>
        <?php endif;

        $editor_settings = $this->getSettings();

        /** @noinspection IsEmptyFunctionUsageInspection */
        if (!empty($this->getHeight())) {
            $editor_settings['editor_height'] = $this->getHeight();
        }

        $editor_settings['readonly'] = $this->isDisabled();

        $is_disabled = $this->isDisabled();

        $tiny_mce_before_init = static function ($args) use ($is_disabled) {

            if ($is_disabled) {
                $args['readonly'] = 1;
            }

            return $args;
        };

        add_filter('tiny_mce_before_init', $tiny_mce_before_init);

        wp_editor($current_value, $this->getId(), $editor_settings);

        remove_filter('tiny_mce_before_init', $tiny_mce_before_init);

        return ob_get_clean();
    }

    /**
     * @return int
     */
    public function getWidth(): ?int {
        return $this->width;
    }

    /**
     * @param int $width
     * @return WYSIWYG
     */
    public function setWidth(int $width): WYSIWYG {
        $this->width = $width;
        return $this;
    }

    /**
     * @return array
     */
    public function getSettings(): array {
        return $this->settings;
    }

    /**
     * @param array $settings
     * @return WYSIWYG
     */
    public function setSettings(array $settings): WYSIWYG {
        $this->settings = $settings;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): ?int {
        return $this->height;
    }

    /**
     * @param int $height
     * @return WYSIWYG
     */
    public function setHeight(int $height): WYSIWYG {
        $this->height = $height;
        return $this;
    }
}