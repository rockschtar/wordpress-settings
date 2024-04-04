<?php

namespace Rockschtar\WordPress\Settings\Models;

/**
 * Class AssetStyle
 * @package Rockschtar\WordPress\Settings
 */
class AssetStyle extends Asset
{
    /**
     * @var string
     */
    private $media;

    /**
     * AssetStyle constructor.
     * @param string $handle
     * @param string $src
     * @param bool $ver
     * @param array $deps
     * @param bool $media
     */
    public function __construct(string $handle, string $src, $ver = false, array $deps = [], $media = false)
    {
        parent::__construct($handle, $src, $ver, $deps);
        $this->type = Asset::TYPE_STYLE;
        $this->media = $media;
    }

    /**
     * @return string
     */
    public function getMedia(): string
    {
        return $this->media;
    }

    /**
     * @param string $media
     * @return AssetStyle
     */
    public function setMedia(string $media): AssetStyle
    {
        $this->media = $media;
        return $this;
    }
}
