<?php

/**
 * Plugin Name:  RWPS Kitchen Sink
 * Description:  Demonstrates all field types of the WordPress Settings framework. Requires the WordPress Settings Wrapper plugin.
 * Version:      1.0.0
 * Requires PHP: 8.2
 * Requires at least: 6.4
 */

use Rockschtar\WordPress\Settings\Fields\AjaxButton;
use Rockschtar\WordPress\Settings\Fields\CheckBox;
use Rockschtar\WordPress\Settings\Fields\CheckBoxList;
use Rockschtar\WordPress\Settings\Fields\Custom;
use Rockschtar\WordPress\Settings\Fields\InputNumber;
use Rockschtar\WordPress\Settings\Fields\InputPhone;
use Rockschtar\WordPress\Settings\Fields\InputText;
use Rockschtar\WordPress\Settings\Fields\InputUrl;
use Rockschtar\WordPress\Settings\Fields\Radio;
use Rockschtar\WordPress\Settings\Fields\SelectBox;
use Rockschtar\WordPress\Settings\Fields\Textarea;
use Rockschtar\WordPress\Settings\Fields\UploadFile;
use Rockschtar\WordPress\Settings\Fields\UploadMedia;
use Rockschtar\WordPress\Settings\Fields\WYSIWYG;
use Rockschtar\WordPress\Settings\Models\ListItem;
use Rockschtar\WordPress\Settings\Models\Section;
use Rockschtar\WordPress\Settings\Models\SettingsPage;

add_action('rswp_create_settings', static function (): void {
    if (!function_exists('rswp_register_settings_page')) {
        return;
    }

    // -------------------------------------------------------------------------
    // Page
    // -------------------------------------------------------------------------
    $page = SettingsPage::create('rwps-kitchen-sink')
        ->setPageTitle('RWPS Kitchen Sink')
        ->setMenuTitle('RWPS Kitchen Sink')
        ->setIcon('dashicons-welcome-widgets-menus')
        ->setPosition(99);

    // -------------------------------------------------------------------------
    // Section: Text Inputs
    // -------------------------------------------------------------------------
    $sectionText = Section::create('rwps-ks-text')
        ->setTitle('Text Inputs')
        ->setCallback(static function (): void {
            echo '<p>Various <code>input</code> field types.</p>';
        });

    InputText::create('rwps_ks_text_basic')
        ->setLabel('Text (basic)')
        ->setDescription('A plain text input.')
        ->setDefaultOption('Hello World')
        ->addToSection($sectionText);

    InputText::create('rwps_ks_text_placeholder')
        ->setLabel('Text (placeholder)')
        ->setPlaceholder('Enter something…')
        ->setDescription('Text input with a placeholder.')
        ->addToSection($sectionText);

    InputText::create('rwps_ks_text_readonly')
        ->setLabel('Text (readonly)')
        ->setReadonly(true)
        ->setDefaultOption('Cannot change me')
        ->addToSection($sectionText);

    InputText::create('rwps_ks_text_disabled')
        ->setLabel('Text (disabled)')
        ->setDisabled(true)
        ->setDefaultOption('Disabled field')
        ->addToSection($sectionText);

    InputText::create('rwps_ks_text_required')
        ->setLabel('Text (required)')
        ->setRequired(true)
        ->setDescription('This field is required.')
        ->addToSection($sectionText);

    InputText::create('rwps_ks_text_datalist')
        ->setLabel('Text (datalist)')
        ->setPlaceholder('Start typing a city…')
        ->addDataListItems('Berlin', 'Hamburg', 'München', 'Köln', 'Frankfurt')
        ->setDescription('Text input with autocomplete datalist.')
        ->addToSection($sectionText);

    InputText::create('rwps_ks_color')
        ->setLabel('Color picker')
        ->setInputType(\Rockschtar\WordPress\Settings\Enums\InputType::color)
        ->setDefaultOption('#3498db')
        ->addToSection($sectionText);

    InputText::create('rwps_ks_email')
        ->setLabel('Email')
        ->setInputType(\Rockschtar\WordPress\Settings\Enums\InputType::email)
        ->setPlaceholder('you@example.com')
        ->addToSection($sectionText);

    InputText::create('rwps_ks_password')
        ->setLabel('Password')
        ->setInputType(\Rockschtar\WordPress\Settings\Enums\InputType::password)
        ->setPlaceholder('••••••••')
        ->addToSection($sectionText);

    InputText::create('rwps_ks_date')
        ->setLabel('Date')
        ->setInputType(\Rockschtar\WordPress\Settings\Enums\InputType::date)
        ->addToSection($sectionText);

    InputNumber::create('rwps_ks_number')
        ->setLabel('Number (0–100, step 0.5)')
        ->setMin(0)
        ->setMax(100)
        ->setStep(0.5)
        ->setDefaultOption(42)
        ->setDescription('InputNumber with min, max, step.')
        ->addToSection($sectionText);

    InputPhone::create('rwps_ks_phone')
        ->setLabel('Phone')
        ->setPlaceholder('+49 123 456789')
        ->setDescription('InputPhone — tel input with pattern support.')
        ->addToSection($sectionText);

    InputUrl::create('rwps_ks_url')
        ->setLabel('URL')
        ->setPlaceholder('https://example.com')
        ->addToSection($sectionText);

    $page->addSection($sectionText);

    // -------------------------------------------------------------------------
    // Section: Multi-line & Rich Text
    // -------------------------------------------------------------------------
    $sectionRich = Section::create('rwps-ks-rich')
        ->setTitle('Multi-line & Rich Text');

    Textarea::create('rwps_ks_textarea')
        ->setLabel('Textarea')
        ->setRows(6)
        ->setCols(60)
        ->setPlaceholder('Enter multi-line text…')
        ->setDescription('Standard textarea. Supports rows, cols, maxlength, placeholder.')
        ->addToSection($sectionRich);

    Textarea::create('rwps_ks_textarea_maxlength')
        ->setLabel('Textarea (maxlength 200)')
        ->setMaxlength(200)
        ->addToSection($sectionRich);

    WYSIWYG::create('rwps_ks_wysiwyg')
        ->setLabel('WYSIWYG editor')
        ->setHeight(300)
        ->setDescription('WordPress TinyMCE editor via <code>wp_editor()</code>.')
        ->addToSection($sectionRich);

    $page->addSection($sectionRich);

    // -------------------------------------------------------------------------
    // Section: Choice Fields
    // -------------------------------------------------------------------------
    $sectionChoice = Section::create('rwps-ks-choice')
        ->setTitle('Choice Fields');

    CheckBox::create('rwps_ks_checkbox')
        ->setLabel('Checkbox')
        ->setValue('yes')
        ->setDescription('Single checkbox — value is "yes" when checked.')
        ->addToSection($sectionChoice);

    CheckBox::create('rwps_ks_checkbox_disabled')
        ->setLabel('Checkbox (disabled)')
        ->setValue('yes')
        ->setDisabled(true)
        ->addToSection($sectionChoice);

    CheckBoxList::create('rwps_ks_checkboxlist')
        ->setLabel('Checkbox list')
        ->addItem(ListItem::create('php', 'PHP'))
        ->addItem(ListItem::create('js', 'JavaScript'))
        ->addItem(ListItem::create('python', 'Python'))
        ->addItem(ListItem::create('rust', 'Rust'))
        ->addItem(ListItem::create('go', 'Go', true))
        ->setDescription('Multiple checkboxes. Last option is disabled.')
        ->addToSection($sectionChoice);

    Radio::create('rwps_ks_radio')
        ->setLabel('Radio buttons')
        ->addItem(ListItem::create('small', 'Small'))
        ->addItem(ListItem::create('medium', 'Medium'))
        ->addItem(ListItem::create('large', 'Large'))
        ->setDefaultOption(['medium'])
        ->addToSection($sectionChoice);

    SelectBox::create('rwps_ks_select')
        ->setLabel('Select (single)')
        ->addItem(ListItem::create('', '— Choose —'))
        ->addItem(ListItem::create('de', 'Deutsch'))
        ->addItem(ListItem::create('en', 'English'))
        ->addItem(ListItem::create('fr', 'Français'))
        ->addItem(ListItem::create('es', 'Español (disabled)', true))
        ->setDescription('Single-select dropdown.')
        ->addToSection($sectionChoice);

    SelectBox::create('rwps_ks_select_multi')
        ->setLabel('Select (multiple)')
        ->setMultiple(true)
        ->addItem(ListItem::create('wp', 'WordPress'))
        ->addItem(ListItem::create('woo', 'WooCommerce'))
        ->addItem(ListItem::create('acf', 'ACF'))
        ->addItem(ListItem::create('yoast', 'Yoast SEO'))
        ->setDescription('Multi-select dropdown — hold Ctrl/Cmd to select multiple.')
        ->addToSection($sectionChoice);

    $page->addSection($sectionChoice);

    // -------------------------------------------------------------------------
    // Section: File Uploads
    // -------------------------------------------------------------------------
    $sectionFiles = Section::create('rwps-ks-files')
        ->setTitle('File Uploads');

    UploadFile::create('rwps_ks_upload_file')
        ->setLabel('File upload')
        ->addAllowedMimeType('pdf', 'application/pdf')
        ->addAllowedMimeType('doc', 'application/msword')
        ->setDescription('Accepts PDF and DOC files. File is stored in the uploads directory.')
        ->addToSection($sectionFiles);

    UploadMedia::create('rwps_ks_upload_media')
        ->setLabel('Media library')
        ->setUploadButtonText('Select media')
        ->setRemoveButtonText('Remove')
        ->setDescription('Opens the WordPress media library.')
        ->addToSection($sectionFiles);

    $page->addSection($sectionFiles);

    // -------------------------------------------------------------------------
    // Section: Custom & Interactive
    // -------------------------------------------------------------------------
    $sectionCustom = Section::create('rwps-ks-custom')
        ->setTitle('Custom & Interactive');

    Custom::create('rwps_ks_custom')
        ->setLabel('Custom field')
        ->setContentCallback(static function (Custom $field, mixed $currentValue): string {
            $value = esc_html($currentValue ?: '(empty)');
            return <<<HTML
                <div style="padding: 8px; background: #f0f4f8; border-left: 4px solid #2271b1;">
                    <strong>Custom callback output.</strong>
                    Current stored value: <code>$value</code>
                </div>
                <input type="text" id="{$field->getId()}" name="{$field->getId()}"
                       value="{$value}" class="regular-text" />
            HTML;
        })
        ->setDescription('Arbitrary HTML via a callback — full control over rendering.')
        ->addToSection($sectionCustom);

    $ajaxButton = AjaxButton::create('rwps_ks_ajax_button')
        ->setLabel('AJAX Button (section)')
        ->setButtonLabel('Run action')
        ->setLabelWait('Running…')
        ->setLabelSuccess('Done!')
        ->setLabelError('Failed')
        ->setCallable(static function (): void {
            // Simulate work
            sleep(1);
            wp_send_json_success('Action completed at ' . current_time('H:i:s'));
        })
        ->setDescription('Button inside a settings section. Sends an AJAX request without saving the form.')
        ->addToSection($sectionCustom);

    $page->addSection($sectionCustom);

    // -------------------------------------------------------------------------
    // Page-level AJAX button (rendered next to the submit button)
    // -------------------------------------------------------------------------
    $pageButton = AjaxButton::create('rwps_ks_page_button')
        ->setButtonLabel('Page-level AJAX')
        ->setLabelWait('Working…')
        ->setLabelSuccess('Done!')
        ->setLabelError('Error')
        ->setPosition(AjaxButton::POSITION_AFTER_SUBMIT)
        ->setCallable(static function (): void {
            wp_send_json_success('Page button fired at ' . current_time('H:i:s'));
        });

    $page->addButton($pageButton);

    rswp_register_settings_page($page);
});
