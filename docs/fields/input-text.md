# InputText

A standard `<input>` field. Supports all HTML input types via the `InputType` enum.

## Input Types

| Constant | HTML type | Use case |
|---|---|---|
| `InputType::text` | `text` | Default plain text |
| `InputType::color` | `color` | Color picker |
| `InputType::email` | `email` | Email address |
| `InputType::password` | `password` | Password (masked) |
| `InputType::date` | `date` | Date picker |
| `InputType::url` | `url` | URL |
| `InputType::number` | `number` | See [`InputNumber`](/fields/input-number) |

## Methods

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create the field |
| `setInputType(InputType $type)` | static | Change the input type (default: `text`) |
| `setPlaceholder(string $text)` | static | Placeholder text |
| `setReadonly(bool $value)` | static | Make field read-only |
| `setDisabled(bool $value)` | static | Disable the field |
| `setAutofocus(bool $value)` | static | Auto-focus on page load |
| `setRequired(bool $value)` | static | Mark as required |
| `setSize(int $chars)` | static | Input width in characters |
| `addCssClass(string ...$classes)` | static | Add CSS classes |
| `addDatalistItem(string $item)` | static | Add a datalist suggestion |
| `addDataListItems(string ...$items)` | static | Add multiple datalist suggestions |

## Examples

### Basic text field

```php
use Rockschtar\WordPress\Settings\Fields\InputText;

InputText::create('my_plugin_name')
    ->setLabel('Name')
    ->setPlaceholder('Enter name…')
    ->setDefaultOption('World')
    ->setSanitizeCallback('sanitize_text_field')
    ->addToSection($section);
```

### Color picker

```php
use Rockschtar\WordPress\Settings\Enums\InputType;
use Rockschtar\WordPress\Settings\Fields\InputText;

InputText::create('my_plugin_color')
    ->setLabel('Brand Color')
    ->setInputType(InputType::color)
    ->setDefaultOption('#3498db')
    ->addToSection($section);
```

### Email field

```php
InputText::create('my_plugin_email')
    ->setLabel('Notification Email')
    ->setInputType(InputType::email)
    ->setPlaceholder('you@example.com')
    ->setSanitizeCallback('sanitize_email')
    ->addToSection($section);
```

### Datalist (autocomplete suggestions)

```php
InputText::create('my_plugin_city')
    ->setLabel('City')
    ->setPlaceholder('Start typing…')
    ->addDataListItems('Berlin', 'Hamburg', 'München', 'Köln')
    ->addToSection($section);
```

## Reading the value

```php
$name = get_option('my_plugin_name', '');
```
