<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Fields;


use Rockschtar\WordPress\Settings\Models\HTMLTag;

class Number extends Textfield {

    /**
     * @var float|null
     */
    private $min;

    /**
     * @var float|null
     */
    private $max;

    /**
     * @var float|null
     */
    private $step;

    public function getHTMLTag($current_value): HTMLTag {
        $html_tag = parent::getHTMLTag($current_value);
        $html_tag->setAttribute('type', 'number');
        $html_tag->setAttribute('min', $this->getMin());
        $html_tag->setAttribute('max', $this->getMax());
        $html_tag->setAttribute('step', $this->getStep());
        return $html_tag;
    }

    /**
     * @return float|null
     */
    public function getMin(): ?float {
        return $this->min;
    }

    /**
     * @param float|null $min
     * @return Number
     */
    public function setMin(?float $min): Number {
        $this->min = $min;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getMax(): ?float {
        return $this->max;
    }

    /**
     * @param float|null $max
     * @return Number
     */
    public function setMax(?float $max): Number {
        $this->max = $max;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getStep(): ?float {
        return $this->step;
    }

    /**
     * @param float|null $step
     * @return Number
     */
    public function setStep(?float $step): Number {
        $this->step = $step;
        return $this;
    }


}