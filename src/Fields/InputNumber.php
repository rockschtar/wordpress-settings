<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Enums\InputType;

class InputNumber extends Input
{
    private ?float $min = null;

    private ?float $max = null;

    private ?float $step = null;

    public function __construct(string $id)
    {
        parent::__construct($id, InputType::number);
    }


    /**
     * @return float|null
     */
    public function getMin(): ?float
    {
        return $this->min;
    }

    /**
     * @param float|null $min
     * @return InputNumber
     */
    public function setMin(?float $min): InputNumber
    {
        $this->min = $min;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getMax(): ?float
    {
        return $this->max;
    }

    /**
     * @param float|null $max
     * @return InputNumber
     */
    public function setMax(?float $max): InputNumber
    {
        $this->max = $max;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getStep(): ?float
    {
        return $this->step;
    }

    /**
     * @param float|null $step
     * @return InputNumber
     */
    public function setStep(?float $step): InputNumber
    {
        $this->step = $step;
        return $this;
    }


    public function attributes(): array
    {
        return [
            'min' => $this->getMin(),
            'max' => $this->getMax(),
            'step' => $this->getStep()
        ];
    }
}
