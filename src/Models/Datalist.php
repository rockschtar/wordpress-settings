<?php

namespace Rockschtar\WordPress\Settings\Models;

/**
 * Class Datalist
 * @package Rockschtar\WordPress\Settings
 */
class Datalist {

    /**
     * @var string|null
     */
    private $id;

    /**
     * @var String[]
     */
    private $items;

    /**
     * Datalist constructor.
     * @param string $id
     * @param String[] $items
     */
    public function __construct(string $id = null, array $items = []) {
        $this->id = $id;
        $this->items = $items;
    }

    /**
     * @param string $id
     * @param String[] $items
     * @return static
     */
    public static function create(string $id = null, array $items = []) {
        $class = static::class;
        return new $class($id, $items);
    }

    /**
     * @param string $item
     * @return Datalist
     */
    public function addItem(string $item): Datalist {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param string $id
     * @return string
     */
    public function getHTML(string $id): string {

        $datalist_id = $this->getId() ?? 'datalist_' . $id;
        $datalist = sprintf('<datalist id="%s">', $datalist_id);

        foreach ($this->getItems() as $item) {
            $datalist .= sprintf('<option value="%s">', $item);
        }

        $datalist .= '</datalist>';

        return $datalist;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Datalist
     */
    public function setId(string $id): Datalist {
        $this->id = $id;
        return $this;
    }

    /**
     * @return String[]
     */
    public function getItems(): array {
        return $this->items;
    }

    /**
     * @param String[] $items
     * @return Datalist
     */
    public function setItems(array $items): Datalist {
        $this->items = $items;
        return $this;
    }

}