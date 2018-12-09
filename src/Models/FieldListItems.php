<?php
/**
 * Created by PhpStorm.
 * User: Stefan Helmer
 * Date: 09.12.2018
 * Time: 14:50
 */

namespace Rockschtar\WordPress\Settings\Models;


use Rockschtar\TypedArrays\TypedArray;

class FieldListItems extends TypedArray {
    public function current(): FieldListItem {
        return parent::current();
    }

    public function add(string $label, string $value): FieldListItems {
        $this->append(FieldListItem::create($label, $value));
        return $this;
    }

    public function getType(): string {
        return FieldListItem::class;
    }

    protected function isDuplicate($value): bool {
        return false;
    }
}