<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Fields;


use Rockschtar\WordPress\Settings\Models\Field;

class WYSIWYG extends Field {

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

        wp_editor($current_value, $this->getId(), $editor_settings);

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