# WordPress Settings Wrapper

> Fluent PHP 8.3 library for the WordPress Settings API — build settings pages without boilerplate.

[![Packagist](https://img.shields.io/packagist/v/rockschtar/wordpress-settings)](https://packagist.org/packages/rockschtar/wordpress-settings)
[![PHP](https://img.shields.io/packagist/dependency-v/rockschtar/wordpress-settings/php)](https://packagist.org/packages/rockschtar/wordpress-settings)
[![License](https://img.shields.io/packagist/l/rockschtar/wordpress-settings)](LICENSE)

**[Full documentation →](https://rockschtar.github.io/wordpress-settings/)**

## Requirements

- PHP 8.3+
- WordPress 6.0+

## Installation

```bash
composer require rockschtar/wordpress-settings
```

## Quick Start

```php
use Rockschtar\WordPress\Settings\Fields\InputText;
use Rockschtar\WordPress\Settings\Fields\SelectBox;
use Rockschtar\WordPress\Settings\Models\ListItem;
use Rockschtar\WordPress\Settings\Models\Section;
use Rockschtar\WordPress\Settings\Models\SettingsPage;

add_action('rswp_create_settings', function (): void {
    $page = SettingsPage::create('my-plugin-settings')
        ->setPageTitle('My Plugin')
        ->setMenuTitle('My Plugin')
        ->setCapability('manage_options');

    $section = Section::create('my-plugin-general', $page)
        ->setTitle('General');

    InputText::create('my_plugin_api_key')
        ->setLabel('API Key')
        ->setDescription('Your API key.')
        ->setPlaceholder('sk-...')
        ->addToSection($section);

    SelectBox::create('my_plugin_environment')
        ->setLabel('Environment')
        ->addItem(ListItem::create('production', 'Production'))
        ->addItem(ListItem::create('staging', 'Staging'))
        ->addItem(ListItem::create('development', 'Development'))
        ->addToSection($section);

    rswp_register_settings_page($page);
});
```

## Field Types

| Field | Description |
|---|---|
| `InputText` | Text, email, password, color, date |
| `InputNumber` | Numeric input with min/max/step |
| `InputPhone` | Tel input with pattern validation |
| `InputUrl` | URL input |
| `Textarea` | Multi-line text |
| `WYSIWYG` | TinyMCE rich-text editor |
| `CheckBox` | Single checkbox |
| `CheckBoxList` | Multiple checkboxes |
| `Radio` | Radio button group |
| `SelectBox` | Dropdown — single or multi-select |
| `UploadFile` | File upload to uploads directory |
| `UploadMedia` | WordPress media library picker |
| `Custom` | Fully custom HTML via callback |
| `AjaxButton` | AJAX-triggered server action |

See the **[full field reference](https://rockschtar.github.io/wordpress-settings/#/fields/)** for all methods and examples.

## Show your support

Give a ⭐️ if this project helped you!
