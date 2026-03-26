# SelectBox

A `<select>` dropdown — single or multiple selection.

## Methods

Inherits all [common field options](/settings-page#common-field-options) plus:

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create the field |
| `addItem(ListItem $item)` | static | Add an option |
| `setMultiple(bool $value)` | static | Allow multiple selections (default: `false`) |
| `setDisabled(bool $value)` | static | Disable the select |
| `setAutofocus(bool $value)` | static | Auto-focus on page load |
| `addCssClass(string ...$classes)` | static | Add CSS classes |

### ListItem

```php
ListItem::create(string $value, string $label, bool $disabled = false)
```

## Examples

### Single select

```php
use Rockschtar\WordPress\Settings\Fields\SelectBox;
use Rockschtar\WordPress\Settings\Models\ListItem;

SelectBox::create('my_plugin_language')
    ->setLabel('Language')
    ->addItem(ListItem::create('',   '— Choose —'))
    ->addItem(ListItem::create('de', 'Deutsch'))
    ->addItem(ListItem::create('en', 'English'))
    ->addItem(ListItem::create('fr', 'Français'))
    ->setDefaultOption('en')
    ->addToSection($section);
```

### Multiple select

```php
SelectBox::create('my_plugin_post_types')
    ->setLabel('Post Types')
    ->setMultiple(true)
    ->addItem(ListItem::create('post', 'Posts'))
    ->addItem(ListItem::create('page', 'Pages'))
    ->addItem(ListItem::create('product', 'Products'))
    ->setDefaultOption(['post'])
    ->addToSection($section);
```

## Reading the value

```php
// Single
$lang = get_option('my_plugin_language', 'en');

// Multiple — stored as array
$types = (array) get_option('my_plugin_post_types', ['post']);
```
