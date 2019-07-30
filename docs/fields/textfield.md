## Textfield 
Display a text field    
    
### Option Details & Methods Type: 
  
[filename](/includes/textfield_default.md ':include')

### Example  
```php  
use Rockschtar\WordPress\Settings\Fields\Textfield;  
use Rockschtar\WordPress\Settings\Models\Section;  
  
$textfield = Textfield::create('my-textbox-id');  
$textfield->setLabel('My Label');  
$textfield->setDescription('This is your checkbox field');  
$textfield->setDefaultOption('Hello World');  
$textfield->setSanitizeCallback(static function($option_value) {  
 //sanitize 
 $option_value = sanitize_text_field($option_value);     
 return $option_value;  
});  
  
$section = Section::create('my-section-id');  
$section->addField($textfield);  
```