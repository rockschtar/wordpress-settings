<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;


use Rockschtar\TypedArrays\Hashmap;
use Rockschtar\TypedArrays\Models\KeyValuePair;

class HTMLTag {

    /**
     * @var String|null
     */
    private $tag;

    /**
     * @var Hashmap
     */
    private $attributes;

    /**
     * HTMLTag constructor.
     * @param String|null $tag
     */
    public function __construct(?String $tag) {
        $this->tag = $tag;
        $this->attributes = new Hashmap();
    }

    /**
     * @param string $attribute
     * @param string $value
     * @return HTMLTag
     */
    public function setAttribute(string $attribute, ?string $value): HTMLTag {

        foreach ($this->attributes as $index => $item) {
            if ($item->getKey() === $attribute) {
                $this->attributes->offsetSet($index, new KeyValuePair($attribute, $value));

                return $this;
            }
        }

        $this->attributes->append(new KeyValuePair($attribute, $value));

        return $this;

    }

    public function buildTag(): string {
        $attributes = [];

        foreach ($this->attributes as $attribute) {

            if ($attribute->getValue() === null) {
                $attributes[] = $attribute->getKey();
            } else {
                $attributes[] = $attribute->getKey() . '="' . $attribute->getValue() . '"';
            }

        }

        return sprintf('<' . $this->getTag() . ' %s />', implode(' ', $attributes));
    }

    /**
     * @return String|null
     */
    public function getTag(): ?String {
        return $this->tag;
    }

    /**
     * @param String|null $tag
     * @return HTMLTag
     */
    public function setTag(?String $tag): HTMLTag {
        $this->tag = $tag;
        return $this;
    }


}