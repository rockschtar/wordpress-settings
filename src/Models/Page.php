<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;


class Page {

    /**
     * @var string
     */
    private $option_group;

    /**
     * @return string
     */
    public function getOptionGroup(): string {
        return $this->option_group;
    }

    /**
     * @param string $option_group
     * @return Page
     */
    public function setOptionGroup(string $option_group): Page {
        $this->option_group = $option_group;
        return $this;
    }



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
    private $menu_titel = 'Custom Settings Page';
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

    public static function create() : Page {
        return new self();
    }

    /**
     * @return Sections
     */
    public function getSections() : Sections {
        return $this->sections;
    }

    /**
     * @param Section $section
     * @return Page
     */
    public function addSection(Section $section): Page {
        if( $this->sections === null) {
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
    public function getMenuTitel(): string {
        return $this->menu_titel;
    }

    /**
     * @param string $menu_titel
     * @return Page
     */
    public function setMenuTitel(string $menu_titel): Page {
        $this->menu_titel = $menu_titel;
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