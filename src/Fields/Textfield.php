<?php
/**
 * Created by PhpStorm.
 * User: Stefan Helmer
 * Date: 27.11.2018
 * Time: 19:35
 */

namespace Rockschtar\WordPress\Settings\Fields;


use Rockschtar\WordPress\Settings\Models\Datalist;
use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\HTMLTag;

class Textfield extends Field {

    public const TEXT = 'text';
    public const COLOR = 'color';
    public const DATE = 'date';
    public const EMAIL = 'email';
    public const PASSWORD = 'password';

    /**
     * @var string
     */
    private $type = self::TEXT;

    /**
     * @var String|null
     */
    private $placeholder;

    /**
     * @var int|null
     */
    private $size;

    /**
     * @var Datalist|null
     */
    private $datalist;


    /**
     * @return int|null
     */
    public function getSize(): ?int {
        return $this->size;
    }

    /**
     * @param int|null $size
     * @return static
     */
    public function setSize(?int $size) {
        $this->size = $size;
        return $this;
    }

    public function getHTMLTag($current_value): HTMLTag {
        $html_tag = parent::getHTMLTag($current_value);
        $html_tag->setAttribute('list', $this->getDatalistId());
        $html_tag->setAttribute('type', $this->getType());
        $html_tag->setAttribute('placeholder', $this->getPlaceholder());
        $html_tag->setAttribute('size', $this->getSize());
        return $html_tag;
    }

    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {
        $html = $this->getHTMLTag($current_value)->buildTag();
        return $html . $this->getDatalistHTML();
    }

    /**
     * @return string
     */
    public function getType(): string {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Textfield
     */
    public function setType(string $type): Textfield {
        $this->type = $type;
        return $this;
    }

    /**
     * @return String|null
     */
    public function getPlaceholder(): ?String {
        return $this->placeholder;
    }

    /**
     * @param String|null $placeholder
     * @return static
     */
    public function setPlaceholder(?String $placeholder) {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @return Datalist|null
     */
    public function getDatalist(): ?Datalist {
        return $this->datalist;
    }

    /**
     * @param Datalist|null $datalist
     * @return static
     */
    public function setDatalist(?Datalist $datalist) {
        $this->datalist = $datalist;
        return $this;
    }

    public function getDatalistId(): ?string {

        if ($this->getDatalist() === null) {
            return null;
        }

        return $this->getDatalist()->getId() ?? 'datalist_' . $this->getId();
    }

    public function getDatalistHTML(): string {
        if ($this->getDatalist() !== null) {
            $datalist_id = $this->getDatalistId();
            $datalist = sprintf('<datalist id="%s">', $datalist_id);

            foreach ($this->getDatalist()->getItems() as $item) {
                $datalist .= sprintf('<option value="%s">', $item);
            }

            $datalist .= '</datalist>';

            return $datalist;
        }

        return '';
    }


}