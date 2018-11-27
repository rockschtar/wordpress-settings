<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Controller;

use Rockschtar\WordPress\Models\Page;
use Rockschtar\WordPress\Models\Section;

abstract class AbstractSettingsController {

    public function __construct() {
        add_action('admin_menu', array($this, 'create_settings'));
        add_action('admin_init', array($this, 'setup_sections'));
        add_action('admin_init', array($this, 'setup_fields'));
    }

    final public function create_settings(): void {
        $page = $this->getPage();
        $callback = $page->getCallback() ?? array($this, 'settings_content');
        add_menu_page($page->getPageTitle(), $page->getMenuTitel(), $page->getCapability(), $page->getSlug(), $callback, $page->getIcon(), $page->getPosition());
    }

    final public function setup_sections(): void {
        foreach($this->getPage()->getSections() as $section) {
            add_settings_section($section->getId(), $section->getTitle(), $section->getCallback(), $section->getOptionGroup());
        }
    }

    final public function setup_fields() : void {
        foreach ($this->getPage()->getSections() as $section) {
            foreach($section->getFields() as $field) {
                add_settings_field($field->getId(), $field->getLabel(),  array($this, 'wph_field_callback'), $section->getOptionGroup(), $section->getId());
                register_setting($section->getOptionGroup(), $field->getId());
            }
        }
    }

    /**
     * @return Section[]
     */
    abstract public function getSections() : array;

    abstract public function getPage() : Page;

    public function settings_content() : void { ?>
        <div class="wrap">
            <h1>Custom Settings Page</h1>
            <?php settings_errors(); ?>
            <form method="POST" action="options.php">
                <?php
                settings_fields('wph_custom');
                do_settings_sections($this->getPage()->getSlug());
                submit_button();
                ?>
            </form>
        </div> <?php
    }





    public function wph_field_callback($field) {
        $value = get_option($field['id']);
        switch ($field['type']) {
            default:
                printf('<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $field['id'], $field['type'], $field['placeholder'], $value);
        }
        if ($desc = $field['desc']) {
            printf('<p class="description">%s </p>', $desc);
        }
    }

}