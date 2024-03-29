<?php

namespace Rockschtar\WordPress\Settings\Traits;

trait DirnameTrait
{
    protected string $dir = '';

    public function getDir(): string
    {
        return $this->dir;
    }
    public function setDir(string $dir): static
    {
        $this->dir = $dir;
        return $this;
    }
}
