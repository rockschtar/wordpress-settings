<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Fields;


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

    public function inputHTML($current_value, array $args = []): string {

        $min = $this->getMin() !== null ? 'min="' . $this->getMin() . '"' : '';
        $max = $this->getMax() !== null ? 'max="' . $this->getMax() . '"' : '';
        $step = $this->getStep() !== null ? 'step="' . $this->getStep() . '"' : '';

        return sprintf('<input name="%1$s" id="%1$s" type="number" placeholder="%2$s" value="%3$s" size="%4$s" %5$s %6$s %7$s %8$s />', $this->getId(), $this->getPlaceholder(), $current_value, $this->getSize(), disabled($this->isDisabled(), true, false), $min, $max, $step);
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