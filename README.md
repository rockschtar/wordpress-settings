# WordPress Settings Wrapper

> A powerful tool designed to streamline the creation of settings pages in WordPress.

## Installation

## Example Usage

```php

add_action('rswp_create_settings', 'my_plugin_create_settings');

function my_plugin_create_settings() {
    $settingsPage = SettingsPage::create('rswp-test-settingspage')
        ->setPageTitle('Test Settings Page')
        ->setMenuTitle('Test Settings Page')
        ->setPosition(22);

    $sectionInputs = Section::create('rswp-test-section', $settingsPage)->setTitle('Inputs')->setCallback(static function() {
        echo "I'm a section callback";
    });
    $sectionCheckBoxes = Section::create('rswp-test-section-checkboxes', $settingsPage)->setTitle('Checkboxes');
    $sectionSelectBoxes = Section::create('rswp-test-section-selectboxes', $settingsPage)->setTitle('Selectboxes');
    $sectionUploads = Section::create('rswp-test-section-uploads', $settingsPage)->setTitle('Uploads');
    $sectionOthers = Section::create('rswp-test-section-others', $settingsPage)->setTitle('Others');


    InputText::create('rswp-test-textfield')
        ->setLabel('InputText')
        ->setDescription('This is a InputTextfield description')
        ->setDefaultOption('Default Value')
        ->setPlaceholder('Placeholder')
        ->setRequired(true)
        ->addCssClass('rswp-input-text-2', 'rswp-input-text-3')
        ->addDatalistItem('Peter')
        ->addDatalistItem('Paul')
        ->addDatalistItem('Mary')
        ->addDataListItems('John', 'Jane', 'Jack')
        ->setSanitizeCallback(static fn($value) => strtoupper($value))
        ->addToSection($sectionInputs);

    InputNumber::create('rswp-test-number')
        ->setLabel('Number')
        ->setDescription('This is a description')
        ->setDefaultOption(5)
        ->setType('integer')
        ->setMin(0)
        ->setMax(100)
        ->setStep(10)
        ->setPlaceholder('Input some number')
        ->addToSection($sectionInputs);

    InputPhone::create('rswp-test-phone')
        ->setLabel('Phoneumber')
        ->setDescription('This is a description')
        ->setDefaultOption(+49123456789)
        ->setPattern('(\+|\d{2})\s?\d{3,5}\s?\d{4,}')
        ->setPlaceholder('Input some phonenumber')->addToSection($sectionInputs);

    InputUrl::create('rswp-test-url')
        ->setLabel('URL')
        ->setDescription('This is a description')
        ->addToSection($sectionInputs);

    Textarea::create('rswp-test-textarea')
        ->setLabel('Textarea')
        ->setDescription('This is a description')
        ->setMaxlength(10)
        ->addToSection($sectionInputs);

    Textarea::create('rswp-test-textarea-dir')
        ->setLabel('Textarea')
        ->setDescription('This is a description')
        ->setCols(100)
        ->setRows(5)
        ->setDir('rtl')
        ->addToSection($sectionInputs);

    CheckBox::create('rswp-test-checkbox')
        ->setLabel('Checkbox')
        ->setDescription('This is a description')
        ->setValue(true)
        ->addToSection($sectionCheckBoxes);

    CheckBoxList::create('rswp-test-checkbox-list')
        ->setLabel('Checkbox')
        ->setDescription('This is a description')
        ->addItem(ListItem::create('1', 'Option 1'))
        ->addItem(ListItem::create('2', 'Option 2'))
        ->addItem(ListItem::create('3', 'Option 3'))
        ->addItem(ListItem::create('4', 'Option 4 Disabled', true))
        ->addItem(ListItem::create('5', 'Option 5'))
        ->addToSection($sectionCheckBoxes);

    SelectBox::create('rwps-text-selextbox')
        ->setLabel('Select')
        ->setDescription('This is a description')
        ->addItem(ListItem::create('1', 'Option 1'))
        ->addItem(ListItem::create('2', 'Option 2'))
        ->addItem(ListItem::create('3', 'Option 3'))
        ->addItem(ListItem::create('4', 'Option 4 Disabled', true))
        ->addToSection($sectionSelectBoxes);

    Select2Box::create('rwps-text-selext2box')
        ->setLabel('Select2')
        ->addItem(ListItem::create('1', 'Option 1'))
        ->addItem(ListItem::create('2', 'Option 2'))
        ->addItem(ListItem::create('3', 'Option 3 Disabled', true))
        ->addItem(ListItem::create('4', 'Option 4'))
        ->addToSection($sectionSelectBoxes);

    SelectBox::create('rwps-text-selextbox2')
        ->setLabel('Select Multiple')
        ->setMultiple(true)
        ->addItem(ListItem::create('1', 'Option 1'))
        ->addItem(ListItem::create('2', 'Option Disabled', true))
        ->addItem(ListItem::create('3', 'Option 3'))
        ->addItem(ListItem::create('4', 'Option 4'))
        ->addToSection($sectionSelectBoxes);

    WYSIWYG::create('rswp-test-wysiwyg')
        ->setLabel('wysiwyg')
        ->setDescription('This is a description')
        ->addToSection($sectionOthers);

    WYSIWYG::create('rswp-test-wysiwyg-2')
        ->setLabel('wysiwyg with size')
        ->setDescription('This is a description')
        ->setWidth(300)
        ->setHeight(200)
        ->addToSection($sectionOthers);

    UploadMedia::create('upload')
        ->setLabel('Upload')
        ->setDescription('Upload some media')
        ->addToSection($sectionUploads);

    UploadFile::create('file-upload')
        ->addAllowedMimeType('ovpn', 'text/plain')
        ->setLabel('File Upload')
        ->addToSection($sectionUploads);


    AjaxButton::create('ajax-button')
        ->setLabel('Ajax Button')
        ->setButtonLabel('Click me')
        ->setDescription('This is a description')
        ->setButtonlabelWait('Please wait...')
        ->setCallable(static function () {
            sleep(2);
            return true;
        })
        ->setJSCallbackDone("alert('Done')")
        ->addToSection($sectionOthers);

    rswp_register_settings_page($settingsPage);
}

```

## Show your support

Give a ⭐️ if this project helped you!

