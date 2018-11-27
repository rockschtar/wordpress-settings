<?php

namespace Rockschtar\WordPress\Models;


use Rockschtar\TypedArrays\TypedArray;

class Sections extends TypedArray {
    public function current() : Section {
        return parent::current();
    }

    public function getType(): string {
        return Section::class;
    }

    protected function isDuplicate($value): bool {
        return false;
    }
}