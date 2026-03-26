# WordPress Settings Wrapper

A fluent PHP 8.3 library that wraps the [WordPress Settings API](https://developer.wordpress.org/plugins/settings/settings-api/) — no boilerplate, just a clean builder interface.

## Requirements

- PHP **8.3+**
- WordPress **6.4+**

## Installation

```bash
composer require rockschtar/wordpress-settings
```

## Quick Start

```php
use Rockschtar\WordPress\Settings\Fields\CheckBox;
use Rockschtar\WordPress\Settings\Fields\InputText;
use Rockschtar\WordPress\Settings\Models\Section;
use Rockschtar\WordPress\Settings\Models\SettingsPage;

add_action('rswp_create_settings', function (): void {

    $section = Section::create('my-plugin-general')
        ->setTitle('General');

    InputText::create('my_plugin_api_key')
        ->setLabel('API Key')
        ->setPlaceholder('sk-…')
        ->setDescription('Your API key.')
        ->addToSection($section);

    CheckBox::create('my_plugin_enabled')
        ->setLabel('Enable feature')
        ->setValue('1')
        ->setDefaultOption('1')
        ->addToSection($section);

    rswp_register_settings_page(
        SettingsPage::create('my-plugin')
            ->setPageTitle('My Plugin Settings')
            ->setMenuTitle('My Plugin')
            ->addSection($section)
    );
});
```

## Available Field Types

| Field | Class |
|---|---|
| Text, Color, Email, Password, Date, URL | [`InputText`](/fields/input-text) |
| Number | [`InputNumber`](/fields/input-number) |
| Phone | [`InputPhone`](/fields/input-phone) |
| URL | [`InputUrl`](/fields/input-url) |
| Textarea | [`Textarea`](/fields/textarea) |
| WYSIWYG editor | [`WYSIWYG`](/fields/wysiwyg) |
| Checkbox | [`CheckBox`](/fields/checkbox) |
| Checkbox list | [`CheckBoxList`](/fields/checkbox-list) |
| Radio buttons | [`Radio`](/fields/radio) |
| Select box | [`SelectBox`](/fields/select-box) |
| File upload | [`UploadFile`](/fields/upload-file) |
| Media library | [`UploadMedia`](/fields/upload-media) |
| Custom (callback) | [`Custom`](/fields/custom) |
| AJAX button | [`AjaxButton`](/fields/ajax-button) |

## License

[MIT](https://choosealicense.com/licenses/mit/)
