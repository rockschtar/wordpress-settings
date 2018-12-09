<?php

namespace Rockschtar\WordPress\Settings\Models;


use Rockschtar\TypedArrays\TypedArray;

class Sections extends TypedArray {

    public function current(): Section {
        return parent::current();
    }

    public function getType(): string {
        return Section::class;
    }

    protected function isDuplicate($value): bool {
        return false;
    }

    public function getSection(string $id): ?Section {

        foreach ($this as $section) {

            if ($section->getId() === $id) {
                return $section;
            }
        }

        return null;
    }

    public function getSectionIndex(string $id): ?int {

        foreach ($this as $index => $section) {

            if ($section->getId() === $id) {
                return $index;
            }

        }

        return null;

    }
}