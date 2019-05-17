<?php

namespace Rockschtar\WordPress\Settings\Models;

/**
 * Class Button
 * @package Rockschtar\WordPress\Settings
 */
abstract class Button extends Field {
    public const POSITION_FORM = 'form';
    public const POSITION_BEFORE_SUBMIT = 'before_submit';
    public const POSITION_AFTER_SUBMIT = 'after_submit';

    /**
     * @var string|null
     */
    private $position = self::POSITION_FORM;

    /**
     * @var string
     */
    private $button_label;

    /**
     * @var String
     */
    private $action;

    /**
     * @var callable
     */
    private $callable;

    /**
     * @return callable
     */
    public function getCallable(): callable {
        return $this->callable;

    }

    /**
     * @param callable $callable
     * @return static
     */
    public function setCallable(callable $callable) {
        $this->callable = $callable;
        return $this;
    }

    /**
     * @return String
     */
    public function getAction(): String {
        return $this->action;
    }

    /**
     * @param String $action
     * @return static
     */
    public function setAction(String $action) {
        $this->action = $action;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPosition(): ?string {
        return $this->position;
    }

    /**
     * @param string|null $position
     * @return static
     */
    public function setPosition(?string $position) {
        $this->position = $position;
        return $this;
    }

    /**
     * @param mixed $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {
        ob_start();
        ?>
        <button type="button" id="<?php $this->getId(); ?>"
                class="button button-secondary rwps-ajax-button rwps-ajax-button-<?php $this->getId(); ?>"><?php echo $this->getButtonLabel(); ?></button>
        <?php

        return ob_get_clean();
    }

    /**
     * @return string
     */
    public function getButtonLabel(): string {

        if (empty($this->button_label)) {
            return $this->getId();
        }

        return $this->button_label;
    }

    /**
     * @param string $button_label
     * @return static
     */
    public function setButtonLabel(string $button_label) {
        $this->button_label = $button_label;
        return $this;
    }
}