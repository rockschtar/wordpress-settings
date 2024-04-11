<?php

namespace Rockschtar\WordPress\Settings\Enqueue;

use Rockschtar\WordPress\Settings\Enums\EnqueueType;

/**
 * Class AssetStyle
 * @package Rockschtar\WordPress\Settings
 */
class EnqueueStyle extends Enqueue
{
    private string | bool $media;

    public function __construct(string $handle, string $src, $ver = false, array $deps = [], string | bool $media = false)
    {
        parent::__construct($handle, $src, $ver, $deps);
        $this->type = EnqueueType::Style;
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
     * @return EnqueueStyle
     */
    public function setMedia(string $media): EnqueueStyle
    {
        $this->media = $media;
        return $this;
    }
}
