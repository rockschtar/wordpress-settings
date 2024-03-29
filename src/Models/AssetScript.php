<?php

namespace Rockschtar\WordPress\Settings\Models;

/**
 * Class AssetScript
 * @package Rockschtar\WordPress\Settings
 */
class AssetScript extends Asset
{
    /**
     * @var bool
     */
    private $in_footer;

    /**
     * @var AssetScriptLocalize|null
     */
    private $localize;

    /**
     * AssetScript constructor.
     * @param string $handle
     * @param string $src
     * @param bool $ver
     * @param array $deps
     * @param bool $in_footer
     */
    public function __construct(string $handle, string $src, $ver = false, array $deps = [], $in_footer = false)
    {
        parent::__construct($handle, $src, $ver, $deps);
        $this->type = Asset::TYPE_SCRIPT;
        $this->in_footer = $in_footer;
    }

    /**
     * @return bool
     */
    public function isInFooter(): bool
    {
        return $this->in_footer;
    }

    /**
     * @param bool $in_footer
     * @return AssetScript
     */
    public function setInFooter(bool $in_footer): AssetScript
    {
        $this->in_footer = $in_footer;
        return $this;
    }

    public function addInlineScript(string $data, string $position = 'after'): AssetScript
    {
        $this->inlines[] = new AssetInlineScript($this->getHandle(), $data, $position);
        return $this;
    }

    /**
     * @return AssetScriptLocalize|null
     */
    public function getLocalize(): ?AssetScriptLocalize
    {
        return $this->localize;
    }

    /**
     * @param AssetScriptLocalize|null $localize
     * @return AssetScript
     */
    public function setLocalize(?AssetScriptLocalize $localize): AssetScript
    {
        $this->localize = $localize;
        return $this;
    }

    public function addLocalize(string $object_name, array $l10n): AssetScript
    {

        if ($this->localize === null) {
            $this->localize = AssetScriptLocalize::create($object_name, $l10n);
        }

        return $this;
    }
}
