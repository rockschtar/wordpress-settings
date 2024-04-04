<?php

namespace Rockschtar\WordPress\Settings\Fields;

use Rockschtar\WordPress\Settings\Models\Asset;
use Rockschtar\WordPress\Settings\Models\Section;
use Rockschtar\WordPress\Settings\Models\SettingsPage;

abstract class Field
{
    private string $label = '';

    private string $id;

    private string $description = '';

    private array $sanitizeArguments = [];

    private mixed $defaultOption = null;

    /**
     * @var callable
     */
    private $sanitizeCallback;

    /**
     * @var \Rockschtar\WordPress\Settings\Models\Asset[]
     */
    private array $assets = [];

    /**
     * @var callable|null
     */
    private $onChange;

    private ?string $type = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function create(string $id): static
    {
        $class = static::class;
        return new $class($id);
    }

    abstract protected function output(mixed $currentValue, array $args = []): string;

    public function processOutput(array $args = []): string
    {
        $currentValue = get_option($this->getId());
        $output = apply_filters('rwps_pre_field_output', $this->output($currentValue, $args), $this->getId());
        if (!empty($this->getDescription())) {
            $output .= sprintf('<p class="description">%s</p>', $this->getDescription());
        }
        $output = apply_filters('rwps_field_output', $output, $this->getId());
        return apply_filters('rwps_field_output' . $this->getId(), $output);
    }

    public function getLabel(): string
    {
        return $this->label;
    }


    public function setLabel(string $label): static
    {
        $this->label = $label;
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }


    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getSanitizeArguments(): array
    {
        return $this->sanitizeArguments;
    }


    public function getDefaultOption(): mixed
    {
        return $this->defaultOption;
    }

    public function setDefaultOption(mixed $defaultOption): static
    {
        $this->defaultOption = $defaultOption;
        return $this;
    }

    public function getSanitizeCallback(): ?callable
    {
        return $this->sanitizeCallback;
    }

    public function setSanitizeCallback(callable $sanitizeCallback, array $arguments = []): static
    {
        $this->sanitizeCallback = $sanitizeCallback;
        $this->sanitizeArguments = $arguments;
        return $this;
    }

    /**
     * @return Asset[]
     */
    public function getAssets(): array
    {
        return $this->assets;
    }

    /**
     * @param Asset[] $assets
     */
    public function setAssets(array $assets): Field
    {
        $this->assets = $assets;
        return $this;
    }

    public function addAsset(Asset $asset): Field
    {
        $this->assets[] = $asset;
        return $this;
    }


    public function getOnChange(): ?callable
    {
        return $this->onChange;
    }

    public function setOnChange(callable $onChange): static
    {
        $this->onChange = $onChange;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getValue(): mixed
    {
        return get_option($this->getId(), $this->getDefaultOption());
    }

    public function addToPage(SettingsPage $page): static
    {
        $page->addField($this);
        return $this;
    }

    public function addToSection(Section $section): static
    {
        $section->addField($this);
        return $this;
    }
}
