<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;


use Rockschtar\TypedArrays\StringArray;

class Datalist {

    /**
     * @var string|null
     */
    private $id;


    /**
     * @var StringArray
     */
    private $items;

    /**
     * Datalist constructor.
     * @param string $id
     * @param StringArray $items
     */
    public function __construct(string $id = null, StringArray $items = null) {
        $this->id = $id;
        $this->items = $items ?? new StringArray();
    }

    /**
     * @param string $id
     * @param StringArray|null $items
     * @return static
     */
    public static function create(string $id = null, StringArray $items = null) {
        $class = static::class;
        return new $class($id, $items);
    }

    /**
     * @param string $item
     * @return Datalist
     */
    public function addItem(string $item): Datalist {
        $this->items->append($item);
        return $this;
    }

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
     * @return StringArray
     */
    public function getItems(): StringArray {
        return $this->items;
    }

    /**
     * @param StringArray $items
     * @return Datalist
     */
    public function setItems(StringArray $items): Datalist {
        $this->items = $items;
        return $this;
    }


}