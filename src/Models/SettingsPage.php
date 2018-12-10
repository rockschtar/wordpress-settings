<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;


class SettingsPage {

    /**
     * @var string
     */
    private $id;
    /**
     * @var Sections
     */
    private $sections;


    /**
     * @var string
     */
    private $page_title = 'Custom Settings Page';
    /**
     * @var string
     */
    private $menu_title = 'Custom Settings Page';
    /**
     * @var string
     */
    private $capability = 'manage_options';
    /**
     * @var string
     */
    private $icon = 'dashicons-admin-settings';
    /**
     * @var int|float
     */
    private $position = 2;
    /**
     * @var ?array|?string|null
     */
    private $callback;


    /**
     * @var Assets
     */
    private $assets;

    /**
     * @var callable|null
     */
    private $admin_footer_hook;

    /**
     * @var Buttons
     */
    private $buttons;

    /**
     * @var string|null
     */
    private $parent;

    /**
     * Page constructor.
     * @param string $id
     */
    private function __construct(string $id) {
        $this->id = $id;
        $this->buttons = new Buttons();
        $this->assets = new Assets();
        $this->sections = new Sections();
    }

    public static function create(string $id): SettingsPage {
        return new self($id);
    }

    /**
     * @return string|null
     */
    public function getParent(): ?string {
        return $this->parent;
    }

    /**
     * @param string|null $parent
     * @return SettingsPage
     */
    public function setParent(?string $parent): SettingsPage {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return callable|null
     */
    public function getAdminFooterHook(): ?callable {
        return $this->admin_footer_hook;
    }

    /**
     * @param callable|null $admin_footer_hook
     * @return SettingsPage
     */
    public function setAdminFooterHook(?callable $admin_footer_hook): SettingsPage {
        $this->admin_footer_hook = $admin_footer_hook;
        return $this;
    }

    /**
     * @param Asset $asset
     * @return SettingsPage
     */
    public function addAsset(Asset $asset): SettingsPage {
        $this->assets->append($asset);
        return $this;
    }

    /**
     * @return Assets
     */
    public function getAssets(): Assets {
        return $this->assets;
    }

    /**
     * @return Sections
     */
    public function getSections(): Sections {
        return $this->sections;
    }

    /**
     * @return string
     */
    public function getPageTitle(): string {
        return $this->page_title;
    }

    /**
     * @param string $page_title
     * @return SettingsPage
     */
    public function setPageTitle(string $page_title): SettingsPage {
        $this->page_title = $page_title;
        return $this;
    }

    /**
     * @return string
     */
    public function getMenuTitle(): string {
        return $this->menu_title;
    }

    /**
     * @param string $menu_title
     * @return SettingsPage
     */
    public function setMenuTitle(string $menu_title): SettingsPage {
        $this->menu_title = $menu_title;
        return $this;
    }

    /**
     * @return string
     */
    public function getCapability(): string {
        return $this->capability;
    }

    /**
     * @param string $capability
     * @return SettingsPage
     */
    public function setCapability(string $capability): SettingsPage {
        $this->capability = $capability;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return SettingsPage
     */
    public function setIcon(string $icon): SettingsPage {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return float|int
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * @param float|int $position
     * @return SettingsPage
     */
    public function setPosition($position): SettingsPage {
        $this->position = $position;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallback() {
        return $this->callback;
    }

    /**
     * @param mixed $callback
     * @return SettingsPage
     */
    public function setCallback($callback): SettingsPage {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @param Button $button
     * @return SettingsPage
     */
    public function addButton(Button $button): SettingsPage {
        $this->buttons->append($button);
        return $this;
    }

    /**
     * @return Buttons
     */
    public function getButtons(): Buttons {
        return $this->buttons;
    }

    public function addField(Field $field): SettingsPage {

        $section = $this->getOrCreateDefaultSection($index);
        $section->addField($field);

        return $this;
    }

    private function getOrCreateDefaultSection(?int &$index = null): Section {
        $section_id = $this->getId() . '-default';

        $section = $this->sections->getSection($section_id);

        if ($section === null) {
            $section = Section::create()->setId($section_id);
            $this->addSection($section);
        }

        $index = $this->sections->getSectionIndex($section_id);
        return $section;
    }

    /**
     * @return string
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * @param string $id
     * @return SettingsPage
     */
    public function setId(string $id): SettingsPage {
        $this->id = $id;
        return $this;
    }

    /**
     * @param Section $section
     * @return SettingsPage
     */
    public function addSection(Section $section): SettingsPage {
        if ($this->sections === null) {
            $this->sections = new Sections();
        }

        $this->sections->append($section);
        return $this;
    }

    /**
     * @return Fields
     */
    public function getFields(): Fields {
        return $this->getOrCreateDefaultSection()->getFields();
    }

    /**
     * @param mixed $fields
     * @return SettingsPage
     */
    public function setFields($fields): SettingsPage {
        $this->getOrCreateDefaultSection()->setFields($fields);
        return $this;
    }

}