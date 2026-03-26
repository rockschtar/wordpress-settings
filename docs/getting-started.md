# Getting Started

## How it works

The library hooks into the WordPress Settings API via the `rswp_create_settings` action. Register your settings pages inside this hook.

```php
add_action('rswp_create_settings', function (): void {
    rswp_register_settings_page($page);
});
```

## Creating a Settings Page

```php
use Rockschtar\WordPress\Settings\Models\SettingsPage;

$page = SettingsPage::create('my-plugin')
    ->setPageTitle('My Plugin Settings')
    ->setMenuTitle('My Plugin')
    ->setCapability('manage_options')
    ->setIcon('dashicons-admin-settings')
    ->setPosition(80);
```

## Adding a Sub-page

To add the settings page as a sub-page of an existing menu (e.g. under *Settings*):

```php
$page = SettingsPage::create('my-plugin')
    ->setPageTitle('My Plugin')
    ->setMenuTitle('My Plugin')
    ->setParent('options-general.php'); // any existing menu slug
```

## Adding Sections

Fields are always placed inside sections. A page can have multiple sections.

```php
use Rockschtar\WordPress\Settings\Models\Section;

$section = Section::create('my-plugin-general')
    ->setTitle('General Settings')
    ->setCallback(function (): void {
        echo '<p>Configure the general options below.</p>';
    });

$page->addSection($section);
```

## Adding Fields

Fields can be added directly to a section:

```php
use Rockschtar\WordPress\Settings\Fields\InputText;

// Fluent — chain directly onto the section
InputText::create('my_plugin_option')
    ->setLabel('My Option')
    ->addToSection($section);

// Or separately
$field = InputText::create('my_plugin_option')->setLabel('My Option');
$section->addField($field);
```

## Registering the Page

```php
rswp_register_settings_page($page);
```

## Full Example

```php
use Rockschtar\WordPress\Settings\Fields\InputText;
use Rockschtar\WordPress\Settings\Fields\SelectBox;
use Rockschtar\WordPress\Settings\Models\ListItem;
use Rockschtar\WordPress\Settings\Models\Section;
use Rockschtar\WordPress\Settings\Models\SettingsPage;

add_action('rswp_create_settings', function (): void {

    $page = SettingsPage::create('my-plugin')
        ->setPageTitle('My Plugin Settings')
        ->setMenuTitle('My Plugin')
        ->setParent('options-general.php');

    $section = Section::create('my-plugin-general')
        ->setTitle('General');

    InputText::create('my_plugin_name')
        ->setLabel('Name')
        ->setPlaceholder('Enter name…')
        ->setSanitizeCallback('sanitize_text_field')
        ->addToSection($section);

    SelectBox::create('my_plugin_mode')
        ->setLabel('Mode')
        ->addItem(ListItem::create('live', 'Live'))
        ->addItem(ListItem::create('sandbox', 'Sandbox'))
        ->setDefaultOption('sandbox')
        ->addToSection($section);

    $page->addSection($section);

    rswp_register_settings_page($page);
});
```

## Reading Option Values

Stored values are standard WordPress options — use `get_option()`:

```php
$name = get_option('my_plugin_name');
$mode = get_option('my_plugin_mode', 'sandbox');
```
