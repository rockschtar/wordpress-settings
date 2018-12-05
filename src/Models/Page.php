<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;


class Page {

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
     * @var callable|null
     */
    private $admin_footer_hook;

    /**
     * Page constructor.
     * @param string $id
     */
    private function __construct(string $id) {
        $this->id = $id;
    }

    /**
     * @return callable|null
     */
    public function getAdminFooterHook(): ?callable {
        return $this->admin_footer_hook;
    }

    /**
     * @param callable|null $admin_footer_hook
     * @return Page
     */
    public function setAdminFooterHook(?callable $admin_footer_hook): Page {
        $this->admin_footer_hook = $admin_footer_hook;
        return $this;
    }

    public static function create(string $id): Page {
        return new self($id);
    }

    /**
     * @return string
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Page
     */
    public function setId(string $id): Page {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Sections
     */
    public function getSections(): Sections {
        return $this->sections;
    }

    /**
     * @param Section $section
     * @return Page
     */
    public function addSection(Section $section): Page {
        if ($this->sections === null) {
            $this->sections = new Sections();
        }

        $this->sections->append($section);
        return $this;
    }

    /**
     * @return string
     */
    public function getPageTitle(): string {
        return $this->page_title;
    }

    /**
     * @param string $page_title
     * @return Page
     */
    public function setPageTitle(string $page_title): Page {
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
     * @return Page
     */
    public function setMenuTitle(string $menu_title): Page {
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
     * @return Page
     */
    public function setCapability(string $capability): Page {
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
     * @return Page
     */
    public function setIcon(string $icon): Page {
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
     * @return Page
     */
    public function setPosition($position): Page {
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
     * @return Page
     */
    public function setCallback($callback): Page {
        $this->callback = $callback;
        return $this;
    }


}