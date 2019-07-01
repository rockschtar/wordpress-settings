## Checkbox  
Display a checkbox field  
  
### Option Details & Methods  
Type: ```checkbox```

|  Method | Type | Description |
|--|--|--|
|  setId| string | Creates a Checkbox instance |
|  setLabel| string | Creates a Checkbox instance |
|  setDescription | string  | Creates a Checkbox instance |
|  setId| string  | Creates a Checkbox instance |
|  setValue| string  | Creates a Checkbox instance |
|  setArguments | array | Creates a Checkbox instance |
|  setDefaultOption | mixed  | Creates a Checkbox instance |
|  setSanitizeCallback| callable | Creates a Checkbox instance |
|  setReadonly| boolean | Creates a Checkbox instance |
|  setDisabled | boolean | Creates a Checkbox instance |
|  addCssClass | string | Creates a Checkbox instance |

### Example
```php
use Rockschtar\WordPress\Settings\Fields\CheckBox;
use Rockschtar\WordPress\Settings\Models\Section;

$checkbox = CheckBox::create('my-checkbox-id');
$checkbox->setValue('1');
$checkbox->setLabel('My Label');
$checkbox->setDescription('This is your checkbox field');
$checkbox->setDefaultOption('1');

$section = Section::create('my-section-id');
$section->addField($checkbox);
```