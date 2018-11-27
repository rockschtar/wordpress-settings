<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Controller;

use Rockschtar\WordPress\Settings\Models\Checkbox;
use Rockschtar\WordPress\Settings\Models\Page;
use Rockschtar\WordPress\Settings\Models\Section;
use Rockschtar\WordPress\Settings\Enum\FieldType;
use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\Textfield;

abstract class AbstractSettingsController {

    public function __construct() {
        add_action('admin_menu', array($this, 'create_settings'));
        add_action('admin_init', array($this, 'setup_sections'));
        add_action('admin_init', array($this, 'setup_fields'));
    }

    final public function create_settings(): void {
        $page = $this->getPage();
        $callback = $page->getCallback() ?? array($this, 'settings_content');
        add_menu_page($page->getPageTitle(), $page->getMenuTitel(), $page->getCapability(), $page->getOptionGroup(), $callback, $page->getIcon(), $page->getPosition());
    }

    final public function setup_sections(): void {
        foreach($this->getPage()->getSections() as $section) {
            add_settings_section($section->getId(), $section->getTitle(), $section->getCallback(), $this->getPage()->getOptionGroup());
        }
    }

    final public function setup_fields() : void {
        foreach ($this->getPage()->getSections() as $section) {
            foreach($section->getFields() as $field) {
                add_settings_field($field->getId(), $field->getLabel(),  array($this, 'field'), $this->getPage()->getOptionGroup(), $section->getId(), ['field' => $field]);
                register_setting($this->getPage()->getOptionGroup(), $field->getId());
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

                settings_fields($this->getPage()->getOptionGroup());

                do_settings_sections($this->getPage()->getOptionGroup());






                submit_button();
                ?>
            </form>
        </div> <?php
    }

    public function field(array $args) : void {
        /* @var Field $field; */
        $field = $args['field'];

        $field_value = get_option($field->getId());

        switch(\get_class($field)) {
            case Textfield::class:
                /* @var Textfield $field; */
                printf('<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $field->getId(), 'text', $field->getPlaceholder(), $field_value);
                break;
            case Checkbox::class:
                /* @var Checkbox $field; */
                $checked = checked($field->getValue(), $field_value, false);
                printf('<input name="%1$s" id="%1$s" type="%2$s" %3$s value="%4$s" />', $field->getId(), 'checkbox', $checked, $field->getValue());
                break;
            case FieldType::CHECKBOX_LIST:
            case FieldType::COLOR:
            case FieldType::DATE:
            case FieldType::EMAIL:
            case FieldType::SELECT:
            case FieldType::MULTISELECT:
            case FieldType::MEDIA:
            case FieldType::NUMBER:
            case FieldType::WYSIWYG:
            default:
                echo 'Unknown field type';
        }
    }

}