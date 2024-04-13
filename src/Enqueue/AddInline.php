<?php

namespace Rockschtar\WordPress\Settings\Enqueue;

abstract class AddInline
{
    private string $handle;

    private string $data;

    public function __construct(string $handle, string $data)
    {
        $this->handle = $handle;
        $this->data = $data;
    }

    public function getHandle(): string
    {
        return $this->handle;
    }

    public function setHandle(string $handle): static
    {
        $this->handle = $handle;
        return $this;
    }

    public function getData(): string
    {
        return $this->data;
    }


    public function setData(string $data): static
    {
        $this->data = $data;
        return $this;
    }
}
