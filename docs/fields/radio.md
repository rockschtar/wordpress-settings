# Radio

A group of `<input type="radio">` buttons. Extends `CheckBoxList` — same API, single-select semantics.

## Methods

Inherits all [common field options](/settings-page#common-field-options) plus:

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create the field |
| `addItem(ListItem $item)` | static | Add a radio option |
| `setDisabled(bool $value)` | static | Disable all options |

### ListItem

```php
ListItem::create(string $value, string $label, bool $disabled = false)
```

## Example

```php
use Rockschtar\WordPress\Settings\Fields\Radio;
use Rockschtar\WordPress\Settings\Models\ListItem;

Radio::create('my_plugin_mode')
    ->setLabel('Mode')
    ->addItem(ListItem::create('live',    'Live'))
    ->addItem(ListItem::create('sandbox', 'Sandbox'))
    ->addItem(ListItem::create('off',     'Off'))
    ->setDefaultOption(['sandbox'])
    ->addToSection($section);
```

## Reading the value

```php
$mode = get_option('my_plugin_mode', 'sandbox');
// Returns the selected value as a string inside an array — flatten it:
if (is_array($mode)) {
    $mode = $mode[0] ?? 'sandbox';
}
```
