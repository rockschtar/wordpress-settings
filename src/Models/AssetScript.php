<?php

namespace Rockschtar\WordPress\Settings\Models;

/**
 * Class AssetScript
 * @package Rockschtar\WordPress\Settings
 */
class AssetScript extends Asset {

    /**
     * @var bool
     */
    private $in_footer;

    /**
     * AssetScript constructor.
     * @param string $handle
     * @param string $src
     * @param bool $ver
     * @param array $deps
     * @param bool $in_footer
     */
    public function __construct(string $handle, string $src, $ver = false, array $deps = [], $in_footer = false) {
        parent::__construct($handle, $src, $ver, $deps);
        $this->type = Asset::TYPE_SCRIPT;
        $this->in_footer = $in_footer;
    }

    /**
     * @return bool
     */
    public function isInFooter(): bool {
        return $this->in_footer;
    }

    /**
     * @param bool $in_footer
     * @return AssetScript
     */
    public function setInFooter(bool $in_footer): AssetScript {
        $this->in_footer = $in_footer;
        return $this;
    }


}