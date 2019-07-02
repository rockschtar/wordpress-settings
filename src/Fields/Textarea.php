<?php
namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\HTMLTag;
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

        $htmlTag = new HTMLTag('textarea');
        $htmlTag->setInnerHTML($current_value);
        $htmlTag->setAttribute('id', $this->getId());
        $htmlTag->setAttribute('name', $this->getId());
        $htmlTag->setAttribute('rows', $this->getRows());
        $htmlTag->setAttribute('cols', $this->getCols());

        if ($this->isAutofocus()) {
            $htmlTag->setAttribute('autofocus');
        }

        if ($this->isDirname()) {
            $htmlTag->setAttribute('dirname', $this->getId() . '.dir"');
        }

        if ($this->getMaxlength()) {
            $htmlTag->setAttribute('maxlength', $this->getMaxlength());
        }

        if ($this->isReadonly()) {
            $htmlTag->setAttribute('readonly');
        }

        if ($this->isDisabled()) {
            $htmlTag->setAttribute('disabled');
        }

        if ($this->getPlaceholder()) {
            $htmlTag->setAttribute('placeholder', $this->getPlaceholder());
        }

        $html = apply_filters('rwps_html_tag', $htmlTag->buildTag());
        $html = apply_filters('rwps_html_tag-' . $this->getId(), $html);

        return $html;
    }
}