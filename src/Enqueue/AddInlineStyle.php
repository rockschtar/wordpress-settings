<?php

namespace Rockschtar\WordPress\Settings\Enqueue;

class AddInlineStyle extends AddInline
{

    public function __construct(string $handle, string $data)
    {
        parent::__construct($handle, $data);
    }

    public static function create(string $handle, string $data): static
    {
        return new static($handle, $data);
    }

}
