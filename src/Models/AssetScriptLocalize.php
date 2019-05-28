<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;


class AssetScriptLocalize {

    /**
     * @var string
     */
    private $object_name;

    /**
     * @var array
     */
    private $l10n = [];

    /**
     * AssetScriptLocalize constructor.
     * @param string $object_name
     * @param array $l10n
     */
    public function __construct(string $object_name, array $l10n) {
        $this->object_name = $object_name;
        $this->l10n = $l10n;
    }

    /**
     * @param string $object_name
     * @param array $l10n
     * @return AssetScriptLocalize
     */
    public static function create(string $object_name, array $l10n): AssetScriptLocalize {
        return new self($object_name, $l10n);
    }

    /**
     * @return string
     */
    public function getObjectName(): string {
        return $this->object_name;
    }

    /**
     * @param string $object_name
     * @return AssetScriptLocalize
     */
    public function setObjectName(string $object_name): AssetScriptLocalize {
        $this->object_name = $object_name;
        return $this;
    }

    /**
     * @return array
     */
    public function getL10n(): array {
        return $this->l10n;
    }

    /**
     * @param array $l10n
     * @return AssetScriptLocalize
     */
    public function setL10n(array $l10n): AssetScriptLocalize {
        $this->l10n = $l10n;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return AssetScriptLocalize
     */
    public function addL10n($key, $value): AssetScriptLocalize {
        $this->l10n[$key] = $value;
        return $this;
    }

}