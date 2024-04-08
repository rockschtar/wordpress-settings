<?php

namespace Rockschtar\WordPress\Settings\Models;

use Rockschtar\WordPress\Settings\Fields\Field;

class SettingsPage
{
    private string $id;

    /**
     * @var Section[]
     */
    private array $sections = [];

    private string $page_title = 'Custom Settings Page';

    private string $menu_title = 'Custom Settings Page';

    private string $capability = 'manage_options';

    private string $icon = 'dashicons-admin-settings';

    private int | float $position = 2;

    /**
     * @var callable
     */
    private $callback;

    /**
     * @var Asset[]
     */
    private array $assets = [];

    /**
     * @var callable
     */
    private $admin_footer_hook;

    /**
     * @var Button[]
     */
    private array $buttons = [];

    private ?string $parent = null;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function create(string $id): SettingsPage
    {
        return new self($id);
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }

    public function setParent(?string $parent): SettingsPage
    {
        $this->parent = $parent;
        return $this;
    }

    public function getAdminFooterHook(): ?callable
    {
        return $this->admin_footer_hook;
    }

    public function setAdminFooterHook(?callable $admin_footer_hook): SettingsPage
    {
        $this->admin_footer_hook = $admin_footer_hook;
        return $this;
    }

    public function addAsset(Asset $asset): SettingsPage
    {
        $this->assets[] = $asset;
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
     * @return Section[]
     */
    public function getSections(): array
    {
        return $this->sections;
    }

    public function getPageTitle(): string
    {
        return $this->page_title;
    }

    public function setPageTitle(string $page_title): SettingsPage
    {
        $this->page_title = $page_title;
        return $this;
    }

    public function getMenuTitle(): string
    {
        return $this->menu_title;
    }

    public function setMenuTitle(string $menu_title): SettingsPage
    {
        $this->menu_title = $menu_title;
        return $this;
    }
    public function getCapability(): string
    {
        return $this->capability;
    }

    public function setCapability(string $capability): SettingsPage
    {
        $this->capability = $capability;
        return $this;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): SettingsPage
    {
        $this->icon = $icon;
        return $this;
    }

    public function getPosition(): float | int
    {
        return $this->position;
    }

    public function setPosition(float | int $position): SettingsPage
    {
        $this->position = $position;
        return $this;
    }

    public function getCallback() : ?callable
    {
        return $this->callback;
    }

    public function setCallback(callable $callback): SettingsPage
    {
        $this->callback = $callback;
        return $this;
    }

    public function addButton(Button $button): SettingsPage
    {
        $this->buttons[] = $button;
        return $this;
    }

    /**
     * @return Button[]
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }

    public function addField(Field $field): SettingsPage
    {
        $section = $this->getOrCreateDefaultSection($index);
        $section->addField($field);

        return $this;
    }

    private function getOrCreateDefaultSection(?int &$index = null): Section
    {
        $section_id = $this->getId() . '-default';

        foreach ($this->sections as $sectionIndex => $section) {
            if ($section->getId() === $section_id) {
                $index = (int)$sectionIndex;
                return $section;
            }
        }

        $section = Section::create($section_id);
        $this->addSection($section);

        return $section;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): SettingsPage
    {
        $this->id = $id;
        return $this;
    }

    public function addSection(Section $section): SettingsPage
    {
        $this->sections[] = $section;
        return $this;
    }

    /**
     * @return Field[]
     */
    public function getFields(): array
    {
        return $this->getOrCreateDefaultSection()->getFields();
    }

    /**
     * @param Field[] $fields
     */
    public function setFields(array $fields): SettingsPage
    {
        $this->getOrCreateDefaultSection()->setFields($fields);
        return $this;
    }
}
