<?php

namespace Rockschtar\WordPress\Settings\Models;

use Rockschtar\WordPress\Settings\Fields\Field;

class Section
{
    private string $id;

    private string $title = '';

    /**
     * @var callable|null
     */
    private $callback;

    /**
     * @var Field[]
     */
    private array $fields = [];

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function create(string $id, ?SettingsPage $page = null): Section
    {
        $instance = new self($id);

        if ($page) {
            $instance->addToPage($page);
        }

        return $instance;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Section
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Section
    {
        $this->title = $title;
        return $this;
    }

    public function getCallback(): ?callable
    {
        return $this->callback;
    }

    public function setCallback(callable $callback): Section
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @return Field[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param Field[] $fields
     */
    public function setFields(array $fields): Section
    {
        $this->fields = $fields;
        return $this;
    }

    public function addField(Field $field): Section
    {
        $this->fields[] = $field;
        return $this;
    }

    public function addToPage(SettingsPage $page): static
    {
        $page->addSection($this);
        return $this;
    }
}
