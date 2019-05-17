<?php

namespace Rockschtar\WordPress\Settings\Models;

class HTMLTag {

    /**
     * @var String|null
     */
    private $tag;

    /**
     * @var Attribute[]
     */
    private $attributes;

    /**
     * HTMLTag constructor.
     * @param String|null $tag
     * @param Attribute[] $attributes
     */
    public function __construct(?String $tag, array $attributes = []) {
        $this->tag = $tag;
        $this->attributes = $attributes;
    }

    /**
     * @param string $name
     * @param string $value
     * @return HTMLTag
     */
    public function setAttribute(string $name, ?string $value = null): HTMLTag {

        foreach ($this->attributes as $index => $attribute) {
            if ($attribute->getName() === $name) {
                $this->attributes[$index] = new Attribute($name, $value);
                return $this;
            }
        }

        $this->attributes[] = new Attribute($name, $value);

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