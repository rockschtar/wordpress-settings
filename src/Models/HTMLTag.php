<?php

namespace Rockschtar\WordPress\Settings\Models;

class HTMLTag {

    /**
     * @var String|null
     */
    private $tag;

    /**
     * @var string|null
     */
    private $innerHTML;

    /**
     * @var bool
     */
    private $withClosingTag = false;

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

    public function removeAttribute(string $attribute): HTMLTag {

        if (array_key_exists($attribute, $this->attributes)) {
            unset($this->attributes[$attribute]);
        }

        return $this;
    }

    public function buildTag(): string {
        $attributes = [];

        foreach ($this->attributes as $attribute) {

            if ($attribute->getValue() === null) {
                $attributes[] = $attribute->getName();
            } else {
                $attributes[] = $attribute->getName() . '="' . $attribute->getValue() . '"';
            }

        }

        if ($this->getInnerHTML() !== null || $this->isWithClosingTag()) {
            return sprintf('<' . $this->getTag() . ' %s>%s</' . $this->getTag() . '>', implode(' ', $attributes), $this->getInnerHTML());
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

    /**
     * @return string|null
     */
    public function getInnerHTML(): ?string {
        return $this->innerHTML;
    }

    /**
     * @param string|null $innerHTML
     */
    public function setInnerHTML(?string $innerHTML): void {
        $this->innerHTML = $innerHTML;
    }

    /**
     * @return bool
     */
    public function isWithClosingTag(): bool {
        return $this->withClosingTag;
    }

    /**
     * @param bool $withClosingTag
     */
    public function setWithClosingTag(bool $withClosingTag): void {
        $this->withClosingTag = $withClosingTag;
    }

}