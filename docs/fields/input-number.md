# InputNumber

A numeric `<input type="number">` with optional min, max, and step constraints.

## Methods

Inherits all [common field options](/settings-page#common-field-options) plus:

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create the field |
| `setMin(float $min)` | static | Minimum allowed value |
| `setMax(float $max)` | static | Maximum allowed value |
| `setStep(float $step)` | static | Increment step |
| `setPlaceholder(string $text)` | static | Placeholder text |
| `setReadonly(bool $value)` | static | Read-only |
| `setDisabled(bool $value)` | static | Disabled |

## Example

```php
use Rockschtar\WordPress\Settings\Fields\InputNumber;

InputNumber::create('my_plugin_timeout')
    ->setLabel('Timeout (seconds)')
    ->setMin(1)
    ->setMax(300)
    ->setStep(1)
    ->setDefaultOption(30)
    ->setSanitizeCallback('absint')
    ->addToSection($section);
```

### Decimal step

```php
InputNumber::create('my_plugin_factor')
    ->setLabel('Factor')
    ->setMin(0.0)
    ->setMax(1.0)
    ->setStep(0.01)
    ->setDefaultOption(0.5)
    ->addToSection($section);
```

## Reading the value

```php
$timeout = (int) get_option('my_plugin_timeout', 30);
```
