<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;


use Rockschtar\TypedArrays\TypedArray;

class Buttons extends TypedArray {
    public function current(): Button {
        return parent::current();
    }


    public function getType(): string {
        return Button::class;
    }

    protected function isDuplicate($value): bool {
        return false;
    }
}