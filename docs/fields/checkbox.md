## Checkbox  
Display a checkbox field  
  
### Option Details & Methods  
Type: ```checkbox```

|  Method | Type | Description |
|--|--|--|
|  setId* | string | 	A unique ID for this option. This ID will be used to get the value for this option.|
|  setLabel| string | The label of the option, for display purposes only.|
|  setDescription | string  | The description to display together with this option. |
|  setValue| string  | The value of the checkbox |
|  setSanitizeCallback| callable | Sets the sanitize-callback function |
|  setArguments | array | Sanitize-Callback Arguments |
|  setReadonly| boolean | Set the checkbox readonly |
|  setDisabled | boolean | Set the checkbox disabled |
|  addCssClass | string | Add custom css-class to the checkbox |

### Example
```php
use Rockschtar\WordPress\Settings\Fields\CheckBox;
use Rockschtar\WordPress\Settings\Models\Section;

$checkbox = CheckBox::create('my-checkbox-id');
$checkbox->setValue('1');
$checkbox->setLabel('My Label');
$checkbox->setDescription('This is your checkbox field');
$checkbox->setDefaultOption('1');
$checkbox->setSanitizeCallback(function($option_value) {
    //sanitize
    $option_value = sanitize_text_field($option_value);
    
    return $option_value;
});

$section = Section::create('my-section-id');
$section->addField($checkbox);
```