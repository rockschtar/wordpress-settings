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

    public function getMin(): ?float
    {
        return $this->min;
    }

    public function setMin(?float $min): InputNumber
    {
        $this->min = $min;
        return $this;
    }

    public function getMax(): ?float
    {
        return $this->max;
    }

    public function setMax(?float $max): InputNumber
    {
        $this->max = $max;
        return $this;
    }

    public function getStep(): ?float
    {
        return $this->step;
    }

    public function setStep(?float $step): InputNumber
    {
        $this->step = $step;
        return $this;
    }

    #[\Override]
    public function attributes(): array
    {
        return [
            'min'  => $this->getMin(),
            'max'  => $this->getMax(),
            'step' => $this->getStep(),
        ];
    }
}
