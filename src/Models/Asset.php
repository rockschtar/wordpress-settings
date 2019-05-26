<?php

namespace Rockschtar\WordPress\Settings\Models;

/**
 * Class Asset
 * @package Rockschtar\WordPress\Settings
 */
abstract class Asset {

    public const TYPE_SCRIPT = 'script';
    public const TYPE_STYLE = 'style';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    private $handle;

    /**
     * @var string
     */
    private $src;

    /**
     * @var string|bool|null
     */
    private $ver;

    /**
     * @var array
     */
    private $deps;

    /**
     * @var AssetInline[]
     */
    protected $inlines = [];

    /**
     * Asset constructor.
     * @param string $handle
     * @param string $src
     * @param bool|string|null $ver
     * @param array $deps
     */
    public function __construct(string $handle, string $src, $ver = false, array $deps = []) {
        $this->handle = $handle;
        $this->src = $src;
        $this->ver = $ver;
        $this->deps = $deps;
    }

    /**
     * @return string
     */
    public function getHandle(): string {
        return $this->handle;
    }

    /**
     * @param string $handle
     * @return Asset
     */
    public function setHandle(string $handle): Asset {
        $this->handle = $handle;
        return $this;
    }

    /**
     * @return string
     */
    public function getSrc(): string {
        return $this->src;
    }

    /**
     * @param string $src
     * @return Asset
     */
    public function setSrc(string $src): Asset {
        $this->src = $src;
        return $this;
    }

    /**
     * @return bool|string|null
     */
    public function getVer() {
        return $this->ver;
    }

    /**
     * @param bool|string|null $ver
     * @return Asset
     */
    public function setVer($ver): Asset {
        $this->ver = $ver;
        return $this;
    }

    /**
     * @return array
     */
    public function getDeps(): array {
        return $this->deps;
    }

    /**
     * @param array $deps
     * @return Asset
     */
    public function setDeps(array $deps): Asset {
        $this->deps = $deps;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @return AssetInline[]
     */
    public function getInlines(): array {
        return $this->inlines;
    }


}