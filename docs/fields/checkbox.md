# CheckBox

A single `<input type="checkbox">`.

## Methods

Inherits all [common field options](/settings-page#common-field-options) plus:

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create the field |
| `setValue(string $value)` | static | The value stored when checked (e.g. `'1'` or `'yes'`) |
| `setReadonly(bool $value)` | static | Prevent interaction (renders `onclick="return false;"` behaviour via `readonly` attribute) |
| `setDisabled(bool $value)` | static | Disable the field |
| `setAutofocus(bool $value)` | static | Auto-focus on page load |

## Example

```php
use Rockschtar\WordPress\Settings\Fields\CheckBox;

CheckBox::create('my_plugin_enabled')
    ->setLabel('Enable feature')
    ->setValue('1')
    ->setDefaultOption('1')        // checked by default
    ->setDescription('Turn the feature on or off.')
    ->addToSection($section);
```

### With sanitize callback

```php
CheckBox::create('my_plugin_debug')
    ->setLabel('Debug mode')
    ->setValue('1')
    ->setSanitizeCallback(static function (mixed $value): string {
        return $value === '1' ? '1' : '0';
    })
    ->addToSection($section);
```

## Reading the value

```php
$enabled = get_option('my_plugin_enabled') === '1';
```
