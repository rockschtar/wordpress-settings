<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Fields;


class Phone extends Textfield {

    /**
     * @var int|null
     */
    private $maxlength;

    /**
     * @var int|null
     */
    private $minlength;

    /**
     * @var string|null
     */
    private $pattern;

    public function inputHTML($current_value, array $args = []): string {

        $minlength = $this->getMinlength() !== null ? 'minlength="' . $this->getMinlength() . '"' : '';
        $maxlength = $this->getMaxlength() !== null ? 'maxlength="' . $this->getMaxlength() . '"' : '';
        $pattern = $this->getPattern() !== null ? 'pattern="' . $this->getPattern() . '"' : '';
        $list = '';
        $datalist = '';

        if ($this->getDatalist() !== null) {
            $datalist_id = $this->getDatalist()->getId() ?? 'datalist_' . $this->getId();
            $list = 'list="' . $datalist_id . '"';
        }

        $input = sprintf('<input name="%1$s" id="%1$s" type="tel" placeholder="%2$s" value="%3$s" size="%4$s" %5$s %6$s %7$s %8$s %9$s/>', $this->getId(), $this->getPlaceholder(), $current_value, $this->getSize(), disabled($this->isDisabled(), true, false), $minlength, $maxlength, $pattern, $list);

        return $input . $this->getDatalistHTML();
    }

    /**
     * @return int|null
     */
    public function getMinlength(): ?int {
        return $this->minlength;
    }

    /**
     * @param int|null $minlength
     * @return Phone
     */
    public function setMinlength(?int $minlength): Phone {
        $this->minlength = $minlength;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxlength(): ?int {
        return $this->maxlength;
    }

    /**
     * @param int|null $maxlength
     * @return Phone
     */
    public function setMaxlength(?int $maxlength): Phone {
        $this->maxlength = $maxlength;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPattern(): ?string {
        return $this->pattern;
    }

    /**
     * @param string|null $pattern
     * @return Phone
     */
    public function setPattern(?string $pattern): Phone {
        $this->pattern = $pattern;
        return $this;
    }


}