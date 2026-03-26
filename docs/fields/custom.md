# Custom

A fully custom field — you provide the rendering callback. Useful for any UI that doesn't fit the built-in field types.

## Methods

Inherits all [common field options](/settings-page#common-field-options) plus:

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create the field |
| `setContentCallback(callable $fn)` | static | Callback that returns the field HTML |

### Callback signature

```php
function (Custom $field, mixed $currentValue, array $args): string
```

| Parameter | Description |
|---|---|
| `$field` | The `Custom` instance — access `$field->getId()` etc. |
| `$currentValue` | Current stored value from `get_option()` |
| `$args` | WordPress settings field args array |

## Example

```php
use Rockschtar\WordPress\Settings\Fields\Custom;

Custom::create('my_plugin_api_status')
    ->setLabel('API Status')
    ->setContentCallback(static function (Custom $field, mixed $currentValue): string {
        $status = my_plugin_check_api_status();
        $color  = $status ? 'green' : 'red';
        $label  = $status ? 'Connected' : 'Disconnected';

        return sprintf(
            '<span style="color:%s">● %s</span>
             <input type="hidden" id="%s" name="%s" value="%s" />',
            esc_attr($color),
            esc_html($label),
            esc_attr($field->getId()),
            esc_attr($field->getId()),
            esc_attr((string) $currentValue)
        );
    })
    ->addToSection($section);
```

### Editable custom field

```php
Custom::create('my_plugin_json_config')
    ->setLabel('JSON Config')
    ->setContentCallback(static function (Custom $field, mixed $currentValue): string {
        $value = esc_textarea((string) $currentValue);
        $id    = esc_attr($field->getId());

        return "<textarea id=\"$id\" name=\"$id\" rows=\"10\" class=\"large-text code\">$value</textarea>";
    })
    ->setSanitizeCallback(static function (mixed $value): string {
        $decoded = json_decode($value, true);
        return $decoded !== null ? wp_json_encode($decoded, JSON_PRETTY_PRINT) : '';
    })
    ->addToSection($section);
```
