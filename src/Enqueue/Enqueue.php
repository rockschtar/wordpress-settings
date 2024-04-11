<?php

namespace Rockschtar\WordPress\Settings\Enqueue;

use Rockschtar\WordPress\Settings\Enums\EnqueueType;

abstract class Enqueue
{
    protected EnqueueType $type;

    private string $handle;

    private string $src;

    private string | bool | null $ver;

    private array $deps;

    /**
     * @var AddInline[]
     */
    protected array $inlines = [];

    public function __construct(string $handle, string $src, string | bool | null $ver = false, array $deps = [])
    {
        $this->handle = $handle;
        $this->src = $src;
        $this->ver = $ver;
        $this->deps = $deps;
    }

    public function getHandle(): string
    {
        return $this->handle;
    }

    public function setHandle(string $handle): Enqueue
    {
        $this->handle = $handle;
        return $this;
    }

    public function getSrc(): string
    {
        return $this->src;
    }

    public function setSrc(string $src): Enqueue
    {
        $this->src = $src;
        return $this;
    }

    public function getVer() : bool | string | null
    {
        return $this->ver;
    }

    public function setVer(bool | string | null $ver): Enqueue
    {
        $this->ver = $ver;
        return $this;
    }

    public function getDeps(): array
    {
        return $this->deps;
    }

    public function setDeps(array $deps): Enqueue
    {
        $this->deps = $deps;
        return $this;
    }

    public function getType() : EnqueueType
    {
        return $this->type;
    }

    /**
     * @return AddInline[]
     */
    public function getInlines(): array
    {
        return $this->inlines;
    }
}
