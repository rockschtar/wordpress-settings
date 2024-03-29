<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Enums\InputType;

class InputUrl extends Input
{
    public function __construct(string $id)
    {
        parent::__construct($id, InputType::url);
    }

    public function attributes(): array
    {
        return [];
    }
}
