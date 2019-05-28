<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;


abstract class AssetInline {
    /**
     * @var string
     */
    private $handle;

    /**
     * @var string
     */
    private $data;

    /**
     * AssetInline constructor.
     * @param string $handle
     * @param string $data
     */
    public function __construct(string $handle, string $data) {
        $this->handle = $handle;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getHandle(): string {
        return $this->handle;
    }

    /**
     * @param string $handle
     * @return static
     */
    public function setHandle(string $handle) {
        $this->handle = $handle;
        return $this;
    }

    /**
     * @return string
     */
    public function getData(): string {
        return $this->data;
    }

    /**
     * @param string $data
     * @return static
     */
    public function setData(string $data) {
        $this->data = $data;
        return $this;
    }


}