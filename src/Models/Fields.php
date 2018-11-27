<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;


use Rockschtar\TypedArrays\TypedArray;

class Fields extends TypedArray {

    public function current() : Field {
        return parent::current();
    }

    public function getType(): string {
       return Field::class;
    }

    protected function isDuplicate($value): bool {
        return false;
    }
}