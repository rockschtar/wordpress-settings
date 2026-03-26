# InputPhone

A `<input type="tel">` field with optional pattern, minlength, and maxlength validation.

## Methods

Inherits all [common field options](/settings-page#common-field-options) plus:

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create the field |
| `setPattern(string $pattern)` | static | HTML pattern attribute (regex) |
| `setMinlength(int $min)` | static | Minimum character length |
| `setMaxlength(int $max)` | static | Maximum character length |
| `setPlaceholder(string $text)` | static | Placeholder text |
| `setReadonly(bool $value)` | static | Read-only |
| `setDisabled(bool $value)` | static | Disabled |

## Example

```php
use Rockschtar\WordPress\Settings\Fields\InputPhone;

InputPhone::create('my_plugin_phone')
    ->setLabel('Phone Number')
    ->setPlaceholder('+49 123 456789')
    ->setPattern('[+][0-9 ]{7,20}')
    ->setMaxlength(20)
    ->setSanitizeCallback('sanitize_text_field')
    ->addToSection($section);
```

## Reading the value

```php
$phone = get_option('my_plugin_phone', '');
```
