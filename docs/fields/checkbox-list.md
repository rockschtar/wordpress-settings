# CheckBoxList

A group of checkboxes rendered inside a `<fieldset>`. The value is saved as an array of selected values.

## Methods

Inherits all [common field options](/settings-page#common-field-options) plus:

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create the field |
| `addItem(ListItem $item)` | static | Add a checkbox option |
| `setDisabled(bool $value)` | static | Disable all checkboxes |

### ListItem

```php
ListItem::create(string $value, string $label, bool $disabled = false)
```

## Example

```php
use Rockschtar\WordPress\Settings\Fields\CheckBoxList;
use Rockschtar\WordPress\Settings\Models\ListItem;

CheckBoxList::create('my_plugin_features')
    ->setLabel('Features')
    ->addItem(ListItem::create('comments', 'Comments'))
    ->addItem(ListItem::create('ratings',  'Ratings'))
    ->addItem(ListItem::create('sharing',  'Social Sharing'))
    ->addItem(ListItem::create('beta',     'Beta Features', true)) // disabled
    ->setDefaultOption(['comments'])
    ->addToSection($section);
```

## Reading the value

The option is stored as an array:

```php
$features = (array) get_option('my_plugin_features', []);

if (in_array('comments', $features, true)) {
    // comments enabled
}
```
