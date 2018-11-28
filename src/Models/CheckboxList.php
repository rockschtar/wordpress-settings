<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;

use Rockschtar\TypedArrays\Hashmap;

class CheckboxList extends Field {

    /**
     * @var Hashmap
     */
    private $values;

    /**
     * @return Hashmap
     */
    public function getValues(): Hashmap {
        return $this->values;
    }

    /**
     * @param Hashmap $values
     * @return CheckboxList
     */
    public function setValues(Hashmap $values): CheckboxList {
        $this->values = $values;
        return $this;
    }
}