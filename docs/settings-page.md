# Settings Page

`SettingsPage` is the top-level container. It holds sections, fields, and page-level buttons.

## Methods

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create a new settings page with the given menu slug |
| `setPageTitle(string $title)` | static | Browser tab and page `<h1>` title |
| `setMenuTitle(string $title)` | static | Label shown in the WP admin menu |
| `setCapability(string $cap)` | static | Required capability (default: `manage_options`) |
| `setIcon(string $icon)` | static | Dashicon slug or base64 SVG (default: `dashicons-admin-settings`) |
| `setPosition(int\|float $pos)` | static | Menu position |
| `setParent(string $slug)` | static | Parent menu slug — makes this a sub-page |
| `addSection(Section $section)` | static | Add a section |
| `addField(Field $field)` | static | Add a field to the default section |
| `addButton(Button $button)` | static | Add a page-level button (rendered next to Submit) |
| `addEnqueue(Enqueue $enqueue)` | static | Enqueue a script or style on this page |
| `setCallback(callable $fn)` | static | Override the default page renderer |
| `setAdminFooterHook(callable $fn)` | static | Callback for the `admin_footer` hook on this page |

## Example

```php
use Rockschtar\WordPress\Settings\Models\SettingsPage;

$page = SettingsPage::create('my-plugin')
    ->setPageTitle('My Plugin Settings')
    ->setMenuTitle('My Plugin')
    ->setCapability('manage_options')
    ->setIcon('dashicons-admin-plugins')
    ->setPosition(75);
```

### Sub-page under Settings

```php
$page = SettingsPage::create('my-plugin')
    ->setPageTitle('My Plugin')
    ->setMenuTitle('My Plugin')
    ->setParent('options-general.php');
```

### Sub-page under a custom top-level menu

```php
$parent = SettingsPage::create('my-plugin-parent')
    ->setPageTitle('My Plugin')
    ->setMenuTitle('My Plugin');

$sub = SettingsPage::create('my-plugin-settings')
    ->setPageTitle('Settings')
    ->setMenuTitle('Settings')
    ->setParent('my-plugin-parent');
```

## Section

Sections group fields visually and in the WP Settings API.

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create a section |
| `setTitle(string $title)` | static | Section heading |
| `setCallback(callable $fn)` | static | Rendered below the section heading |
| `addField(Field $field)` | static | Add a field |

```php
use Rockschtar\WordPress\Settings\Models\Section;

$section = Section::create('my-plugin-advanced')
    ->setTitle('Advanced')
    ->setCallback(function (): void {
        echo '<p>Advanced options — change with care.</p>';
    });
```

## Common Field Options

These methods are available on **every** field type:

| Method | Type | Description |
|---|---|---|
| `setLabel(string $label)` | static | Field label shown in the table |
| `setDescription(string $desc)` | static | Help text rendered below the field |
| `setDefaultOption(mixed $value)` | static | Default value when option is not yet saved |
| `setSanitizeCallback(callable $fn)` | static | Sanitize the value before saving |
| `setOnChange(callable $fn)` | static | Called when the option value changes |
| `setShowInRest(bool $show)` | static | Expose option via the REST API |
| `addEnqueue(Enqueue $enqueue)` | static | Enqueue assets when this field is displayed |
| `addToSection(Section $section)` | static | Add this field to a section (fluent shorthand) |
| `addToPage(SettingsPage $page)` | static | Add to page default section (fluent shorthand) |
