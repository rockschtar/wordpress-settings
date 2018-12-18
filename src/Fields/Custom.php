<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Fields;


use Rockschtar\WordPress\Settings\Models\Field;

class Custom extends Field {

    /**
     * @var string|null
     */
    private $content;

    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {
        return $this->getContent();
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string {
        return $this->content;
    }

    /**
     * @param string|null $content
     * @return Custom
     */
    public function setContent(?string $content): Custom {
        $this->content = $content;
        return $this;
    }


}