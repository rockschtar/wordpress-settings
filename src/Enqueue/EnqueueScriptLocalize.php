<?php

namespace Rockschtar\WordPress\Settings\Enqueue;

class EnqueueScriptLocalize
{
    private string $objectName;

    private array $l10n = [];

    public function __construct(string $objectName, array $l10n)
    {
        $this->objectName = $objectName;
        $this->l10n = $l10n;
    }

    public static function create(string $objectName, array $l10n): EnqueueScriptLocalize
    {
        return new self($objectName, $l10n);
    }

    public function getObjectName(): string
    {
        return $this->objectName;
    }

    public function setObjectName(string $objectName): EnqueueScriptLocalize
    {
        $this->objectName = $objectName;
        return $this;
    }

    public function getL10n(): array
    {
        return $this->l10n;
    }

    public function setL10n(array $l10n): EnqueueScriptLocalize
    {
        $this->l10n = $l10n;
        return $this;
    }

    public function addL10n(string $key, mixed $value): EnqueueScriptLocalize
    {
        $this->l10n[$key] = $value;
        return $this;
    }
}
