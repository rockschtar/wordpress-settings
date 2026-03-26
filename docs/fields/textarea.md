# Textarea

A `<textarea>` field for multi-line text input.

## Methods

Inherits all [common field options](/settings-page#common-field-options) plus:

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create the field |
| `setRows(int $rows)` | static | Number of visible rows (default: `10`) |
| `setCols(int $cols)` | static | Number of visible columns (default: `80`) |
| `setMaxlength(int $max)` | static | Maximum character count |
| `setPlaceholder(string $text)` | static | Placeholder text |
| `setWrap(string $wrap)` | static | Wrapping mode: `soft` or `hard` |
| `setDir(string $dir)` | static | Text direction (`ltr` or `rtl`) — also adds `dirname` attribute |
| `setReadonly(bool $value)` | static | Read-only |
| `setDisabled(bool $value)` | static | Disabled |
| `setAutofocus(bool $value)` | static | Auto-focus on page load |

## Example

```php
use Rockschtar\WordPress\Settings\Fields\Textarea;

Textarea::create('my_plugin_notes')
    ->setLabel('Notes')
    ->setRows(8)
    ->setCols(60)
    ->setMaxlength(1000)
    ->setPlaceholder('Enter your notes…')
    ->setSanitizeCallback('sanitize_textarea_field')
    ->addToSection($section);
```

## Reading the value

```php
$notes = get_option('my_plugin_notes', '');
```
