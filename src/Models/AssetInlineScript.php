<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;


class AssetInlineScript extends AssetInline {

    /**
     * @var string
     */
    private $position;

    /**
     * AssetInlineScript constructor.
     * @param string $handle
     * @param string $data
     * @param string $position
     */
    public function __construct(string $handle, string $data, string $position = 'after') {
        parent::__construct($handle, $data);
        $this->position = $position;
    }

    public static function create(string $handle, string $data, string $position = 'after'): AssetInlineScript {
        return new self($handle, $data, $position);
    }


    /**
     * @return string
     */
    public function getPosition(): string {
        return $this->position;
    }

    /**
     * @param string $position
     * @return AssetInlineScript
     */
    public function setPosition(string $position): AssetInlineScript {
        $this->position = $position;
        return $this;
    }


}