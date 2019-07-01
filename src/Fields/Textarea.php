<?php
namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Traits\DisabledTrait;
use Rockschtar\WordPress\Settings\Traits\PlaceholderTrait;
use Rockschtar\WordPress\Settings\Traits\ReadOnlyTrait;

class Textarea extends Field {

    use ReadOnlyTrait;

    use DisabledTrait;

    use PlaceholderTrait;

    /**
     * @var bool
     */
    private $autofocus = false;

    /**
     * @var bool
     */
    private $dirname = false;

    /**
     * @var int
     */
    private $cols = 80;

    /**
     * @var int
     */
    private $rows = 10;

    /**
     * @var int|null
     */
    private $maxlength;

    /**
     * @var string
     */
    private $wrap;

    /**
     * @return bool
     */
    public function isAutofocus(): bool {
        return $this->autofocus;
    }

    /**
     * @param bool $autofocus
     * @return Textarea
     */
    public function setAutofocus(bool $autofocus): Textarea {
        $this->autofocus = $autofocus;
        return $this;
    }

    /**
     * @return int
     */
    public function getCols(): int {
        return $this->cols;
    }

    /**
     * @param int $cols
     * @return Textarea
     */
    public function setCols(int $cols): Textarea {
        $this->cols = $cols;
        return $this;
    }

    /**
     * @return int
     */
    public function getRows(): int {
        return $this->rows;
    }

    /**
     * @param int $rows
     * @return Textarea
     */
    public function setRows(int $rows): Textarea {
        $this->rows = $rows;
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
     * @return Textarea
     */
    public function setMaxlength(?int $maxlength): Textarea {
        $this->maxlength = $maxlength;
        return $this;
    }


    /**
     * @return string
     */
    public function getWrap(): string {
        return $this->wrap;
    }

    /**
     * @param string $wrap
     * @return Textarea
     */
    public function setWrap(string $wrap): Textarea {
        $this->wrap = $wrap;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDirname(): bool {
        return $this->dirname;
    }

    /**
     * @param bool $dirname
     * @return Textarea
     */
    public function setDirname(bool $dirname): Textarea {
        $this->dirname = $dirname;
        return $this;
    }

    /**
     * @param $current_value
     * @param array $args
     * @return string
     */
    public function inputHTML($current_value, array $args = []): string {

        $textareatTemplate = '<textarea id="{id}" name="{name}" rows="{rows}" cols="{cols}" {attributes}>{value}</textarea>';

        $textareatTemplate = str_replace(array('{id}', '{name}', '{rows}', '{cols}', '{value}'), array($this->getId(),
                                                                                                       $this->getId(),
                                                                                                       $this->getRows(),
                                                                                                       $this->getCols(),
                                                                                                       $current_value), $textareatTemplate);
        $attributes = [];

        if ($this->isAutofocus()) {
            $attributes[] = 'autofocus';
        }

        if ($this->isDirname()) {
            $attributes[] = 'dirname="' . $this->getId() . '.dir"';
        }

        if ($this->getMaxlength()) {
            $attributes[] = 'maxlength="' . $this->getMaxlength() . '"';
        }

        $textarea = str_replace('{attributes}', implode(' ', $attributes), $textareatTemplate);

        return $textarea;
    }
}