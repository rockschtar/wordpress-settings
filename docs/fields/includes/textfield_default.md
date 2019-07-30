|  Method | Type | Description |
|--|--|--|
|  setId* | string | A unique ID for this option. This ID will be used to get the value for this option.|  
| setLabel | string | The label of the option, for display purposes only.|
| setDescription | string | The description to display together with this option. | 
| setPlaceholder| string | The text to display inside the text field when the field is empty. |  
| setSanitizeCallback | callable | Sets the sanitize-callback function |
| setReadonly| boolean | Set the field readonly |
| setDisabled | boolean | Set the field disabled |
| setDefaultOption | mixed | The default value to return if the option does not exist in the database. See [https://developer.wordpress.org/reference/hooks/default_option_option/](https://developer.wordpress.org/reference/hooks/default_option_option/) for more information |  
|  setAutofocus | boolean | When true, it specifies that the field should automatically get focus when the page loads. | 
|  addCssClass | string | Add custom css-class to the text field|
|  addAsset| Asset| Add custom asset when the field is displayed |
|  setDatalist| Datalist| Sets the datalist for the field. See [https://www.w3schools.com/tags/att_input_list.asp](https://www.w3schools.com/tags/att_input_list.asp) for more information|  
|  setOverrideOption| mixed| Overrides the option with the given value |
|  setSize | integer| Specifies the width, in characters, of the field |