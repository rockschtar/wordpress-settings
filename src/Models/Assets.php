<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;


use Rockschtar\TypedArrays\TypedArray;

class Assets extends TypedArray {
    public function current(): Asset {
        return parent::current();
    }

    public function getType(): string {
        return Asset::class;
    }

    protected function isDuplicate($value): bool {
        return false;
    }
}