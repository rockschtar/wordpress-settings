# InputUrl

A `<input type="url">` field. Browsers validate the URL format natively.

## Methods

Inherits all [common field options](/settings-page#common-field-options) plus:

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create the field |
| `setPlaceholder(string $text)` | static | Placeholder text |
| `setReadonly(bool $value)` | static | Read-only |
| `setDisabled(bool $value)` | static | Disabled |
| `setRequired(bool $value)` | static | Required |

## Example

```php
use Rockschtar\WordPress\Settings\Fields\InputUrl;

InputUrl::create('my_plugin_webhook_url')
    ->setLabel('Webhook URL')
    ->setPlaceholder('https://example.com/webhook')
    ->setSanitizeCallback('esc_url_raw')
    ->addToSection($section);
```

## Reading the value

```php
$url = get_option('my_plugin_webhook_url', '');
```
