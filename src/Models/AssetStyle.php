<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;

class AssetStyle extends Asset {

    /**
     * @var string
     */
    private $media;

    public function __construct(string $handle, string $src, $ver = false, array $deps = [], $media = false) {
        parent::__construct($handle, $src, $ver, $deps);
        $this->type = Asset::TYPE_STYLE;
        $this->media = $media;
    }

    /**
     * @return string
     */
    public function getMedia(): string {
        return $this->media;
    }

    /**
     * @param string $media
     * @return AssetStyle
     */
    public function setMedia(string $media): AssetStyle {
        $this->media = $media;
        return $this;
    }


}