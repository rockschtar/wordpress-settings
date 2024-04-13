<?php

namespace Rockschtar\WordPress\Settings\Enqueue;

use Rockschtar\WordPress\Settings\Enums\EnqueueType;

class EnqueueScript extends Enqueue
{
    private bool $inFooter;

    private ?EnqueueScriptLocalize $localize = null;

    public function __construct(string $handle, string $src = '', $ver = false, array $deps = [], $in_footer = false)
    {
        parent::__construct($handle, $src, $ver, $deps);
        $this->type = EnqueueType::Script;
        $this->inFooter = $in_footer;
    }

    public static function create(string $handle): EnqueueScript
    {
        return new self($handle);
    }

    public function isInFooter(): bool
    {
        return $this->inFooter;
    }

    public function setInFooter(bool $inFooter): EnqueueScript
    {
        $this->inFooter = $inFooter;
        return $this;
    }

    public function addInlineScript(string $data, string $position = 'after'): EnqueueScript
    {
        $this->inlines[] = new AddInlineScript($this->getHandle(), $data, $position);
        return $this;
    }

    public function getLocalize(): ?EnqueueScriptLocalize
    {
        return $this->localize;
    }

    public function setLocalize(?EnqueueScriptLocalize $localize): EnqueueScript
    {
        $this->localize = $localize;
        return $this;
    }

    public function addLocalize(string $object_name, array $l10n): EnqueueScript
    {

        if ($this->localize === null) {
            $this->localize = EnqueueScriptLocalize::create($object_name, $l10n);
        }

        return $this;
    }
}
