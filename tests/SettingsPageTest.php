<?php

namespace Rockschtar\WordPress\Settings\Tests;

use Brain\Monkey;
use Brain\Monkey\Functions;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Rockschtar\WordPress\Settings\Enums\InputType;
use Rockschtar\WordPress\Settings\Fields\CheckBox;
use Rockschtar\WordPress\Settings\Fields\CheckBoxList;
use Rockschtar\WordPress\Settings\Fields\Field;
use Rockschtar\WordPress\Settings\Fields\InputNumber;
use Rockschtar\WordPress\Settings\Fields\InputText;
use Rockschtar\WordPress\Settings\Fields\Radio;
use Rockschtar\WordPress\Settings\Fields\SelectBox;
use Rockschtar\WordPress\Settings\Fields\Textarea;
use Rockschtar\WordPress\Settings\Models\ListItem;
use Rockschtar\WordPress\Settings\Models\Section;
use Rockschtar\WordPress\Settings\Models\SettingsPage;

class SettingsPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();

        // Stub WP functions used during output rendering
        Functions\when('get_option')->justReturn('');
        Functions\when('apply_filters')->returnArg(2);
        Functions\when('checked')->justReturn('');
        Functions\when('selected')->justReturn('');
        Functions\when('disabled')->justReturn('');
        Functions\when('esc_html')->returnArg(1);
        Functions\when('esc_attr')->returnArg(1);
    }

    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }

    // -------------------------------------------------------------------------
    // SettingsPage builder
    // -------------------------------------------------------------------------

    public function testSettingsPageBuilder(): void
    {
        $page = SettingsPage::create('my-page')
            ->setPageTitle('My Page Title')
            ->setMenuTitle('My Menu Title')
            ->setCapability('manage_options')
            ->setPosition(25);

        $this->assertSame('my-page', $page->getId());
        $this->assertSame('My Page Title', $page->getPageTitle());
        $this->assertSame('My Menu Title', $page->getMenuTitle());
        $this->assertSame('manage_options', $page->getCapability());
        $this->assertSame(25, $page->getPosition());
    }

    public function testSettingsPageAddSection(): void
    {
        $page    = SettingsPage::create('my-page');
        $section = Section::create('my-section');
        $page->addSection($section);

        $this->assertCount(1, $page->getSections());
        $this->assertSame('my-section', $page->getSections()[0]->getId());
    }

    public function testSettingsPageAddFieldCreatesDefaultSection(): void
    {
        $page  = SettingsPage::create('my-page');
        $field = InputText::create('my-field');
        $page->addField($field);

        $this->assertCount(1, $page->getSections());
        $this->assertCount(1, $page->getFields());
    }

    public function testSettingsPageParent(): void
    {
        $page = SettingsPage::create('sub-page')->setParent('options-general.php');
        $this->assertSame('options-general.php', $page->getParent());
    }

    // -------------------------------------------------------------------------
    // Section builder
    // -------------------------------------------------------------------------

    public function testSectionBuilder(): void
    {
        $section = Section::create('my-section')
            ->setTitle('My Section Title');

        $this->assertSame('my-section', $section->getId());
        $this->assertSame('My Section Title', $section->getTitle());
    }

    public function testSectionAddField(): void
    {
        $section = Section::create('my-section');
        $field   = InputText::create('my-field');
        $section->addField($field);

        $this->assertCount(1, $section->getFields());
    }

    // -------------------------------------------------------------------------
    // InputText
    // -------------------------------------------------------------------------

    public function testInputTextOutput(): void
    {
        $field  = InputText::create('my-text');
        $output = $field->output('hello');

        $this->assertStringContainsString('type="text"', $output);
        $this->assertStringContainsString('id="my-text"', $output);
        $this->assertStringContainsString('name="my-text"', $output);
        $this->assertStringContainsString('value="hello"', $output);
    }

    #[DataProvider('inputTypeProvider')]
    public function testInputTextTypes(InputType $type, string $expectedTypeName): void
    {
        $field  = new InputText('field-type', $type);
        $output = $field->output('');
        $this->assertStringContainsString('type="' . $expectedTypeName . '"', $output);
    }

    public static function inputTypeProvider(): array
    {
        return [
            'color'    => [InputType::color,    'color'],
            'email'    => [InputType::email,    'email'],
            'password' => [InputType::password, 'password'],
            'date'     => [InputType::date,     'date'],
            'url'      => [InputType::url,      'url'],
            'number'   => [InputType::number,   'number'],
        ];
    }

    public function testInputTextDatalist(): void
    {
        $field = InputText::create('my-text')
            ->addDataListItems('Berlin', 'Hamburg', 'München');

        $output = $field->output('');

        $this->assertStringContainsString('<datalist id="my-text_datalist">', $output);
        $this->assertStringContainsString('<option value="Berlin">', $output);
        $this->assertStringContainsString('<option value="Hamburg">', $output);
        $this->assertStringContainsString('<option value="München">', $output);
        $this->assertStringContainsString('list="my-text_datalist"', $output);
    }

    // -------------------------------------------------------------------------
    // InputNumber
    // -------------------------------------------------------------------------

    public function testInputNumberOutput(): void
    {
        $field  = InputNumber::create('my-number')
            ->setMin(0.0)
            ->setMax(100.0)
            ->setStep(0.5);

        $output = $field->output(42);

        $this->assertStringContainsString('type="number"', $output);
        $this->assertStringContainsString('min="0"', $output);
        $this->assertStringContainsString('max="100"', $output);
        $this->assertStringContainsString('step="0.5"', $output);
    }

    // -------------------------------------------------------------------------
    // Textarea
    // -------------------------------------------------------------------------

    public function testTextareaOutput(): void
    {
        $field  = Textarea::create('my-textarea');
        $output = $field->output('some content');

        $this->assertStringContainsString('<textarea', $output);
        $this->assertStringContainsString('id="my-textarea"', $output);
        $this->assertStringContainsString('name="my-textarea"', $output);
        $this->assertStringContainsString('some content</textarea>', $output);
    }

    public function testTextareaRowsCols(): void
    {
        $field  = Textarea::create('my-textarea')->setRows(20)->setCols(40);
        $output = $field->output('');

        $this->assertStringContainsString('rows="20"', $output);
        $this->assertStringContainsString('cols="40"', $output);
    }

    public function testTextareaDirname(): void
    {
        $field  = Textarea::create('my-textarea')->setDir('ltr');
        $output = $field->output('');

        $this->assertStringContainsString('dirname="my-textarea.dir"', $output);
        $this->assertStringContainsString('dir="ltr"', $output);
    }

    public function testTextareaMaxlength(): void
    {
        $field  = Textarea::create('my-textarea')->setMaxlength(500);
        $output = $field->output('');

        $this->assertStringContainsString('maxlength="500"', $output);
    }

    // -------------------------------------------------------------------------
    // CheckBox
    // -------------------------------------------------------------------------

    public function testCheckBoxOutput(): void
    {
        $field  = CheckBox::create('my-checkbox')->setValue('yes');
        $output = $field->output('');

        $this->assertStringContainsString('type="checkbox"', $output);
        $this->assertStringContainsString('id="my-checkbox"', $output);
        $this->assertStringContainsString('name="my-checkbox"', $output);
        $this->assertStringContainsString('value="yes"', $output);
    }

    public function testCheckBoxReadonlyRendersAttribute(): void
    {
        $field  = CheckBox::create('my-checkbox')->setReadonly(true);
        $output = $field->output('');

        $this->assertStringContainsString('readonly', $output);
    }

    // -------------------------------------------------------------------------
    // CheckBoxList
    // -------------------------------------------------------------------------

    public function testCheckBoxListOutput(): void
    {
        $field = CheckBoxList::create('my-cblist')
            ->addItem(ListItem::create('apple', 'Apple'))
            ->addItem(ListItem::create('banana', 'Banana'));

        $output = $field->output([]);

        $this->assertStringContainsString('<fieldset>', $output);
        $this->assertStringContainsString('type="checkbox"', $output);
        $this->assertStringContainsString('value="apple"', $output);
        $this->assertStringContainsString('value="banana"', $output);
        $this->assertStringContainsString('name="my-cblist[]"', $output);
    }

    // -------------------------------------------------------------------------
    // Radio
    // -------------------------------------------------------------------------

    public function testRadioOutput(): void
    {
        $field = Radio::create('my-radio')
            ->addItem(ListItem::create('yes', 'Yes'))
            ->addItem(ListItem::create('no', 'No'));

        $output = $field->output([]);

        $this->assertStringContainsString('type="radio"', $output);
        $this->assertStringContainsString('value="yes"', $output);
        $this->assertStringContainsString('value="no"', $output);
    }

    // -------------------------------------------------------------------------
    // SelectBox
    // -------------------------------------------------------------------------

    public function testSelectBoxOutput(): void
    {
        $field = SelectBox::create('my-select')
            ->addItem(ListItem::create('de', 'Deutsch'))
            ->addItem(ListItem::create('en', 'English'));

        $output = $field->output('de');

        $this->assertStringContainsString('<select', $output);
        $this->assertStringContainsString('id="my-select"', $output);
        $this->assertStringContainsString('name="my-select"', $output);
        $this->assertStringContainsString('value="de"', $output);
        $this->assertStringContainsString('value="en"', $output);
    }

    public function testSelectBoxMultiple(): void
    {
        $field  = SelectBox::create('my-select')->setMultiple(true);
        $output = $field->output([]);

        $this->assertStringContainsString('multiple="multiple"', $output);
        $this->assertStringContainsString('name="my-select[]"', $output);
    }

    // -------------------------------------------------------------------------
    // Shared trait assertions via processOutput()
    // -------------------------------------------------------------------------

    #[DataProvider('fieldWithReadonlyProvider')]
    public function testReadonly(Field $field): void
    {
        $field->setReadonly(true);
        $this->assertStringContainsString('readonly', $field->processOutput());
    }

    #[DataProvider('fieldWithDisabledProvider')]
    public function testDisabled(Field $field): void
    {
        $field->setDisabled(true);
        $this->assertStringContainsString('disabled', $field->processOutput());
    }

    #[DataProvider('fieldWithAutofocusProvider')]
    public function testAutofocus(Field $field): void
    {
        $field->setAutofocus(true);
        $this->assertStringContainsString('autofocus', $field->processOutput());
    }

    #[DataProvider('fieldWithPlaceholderProvider')]
    public function testPlaceholder(Field $field): void
    {
        $field->setPlaceholder('Enter value');
        $this->assertStringContainsString('placeholder="Enter value"', $field->processOutput());
    }

    public function testDescription(): void
    {
        $field = InputText::create('my-field')->setDescription('Help text here');
        $this->assertStringContainsString('<p class="description">Help text here</p>', $field->processOutput());
    }

    // -------------------------------------------------------------------------
    // Data providers
    // -------------------------------------------------------------------------

    public static function fieldWithReadonlyProvider(): array
    {
        return [
            'InputText'  => [InputText::create('f')],
            'InputNumber' => [InputNumber::create('f')],
            'Textarea'   => [Textarea::create('f')],
            'CheckBox'   => [CheckBox::create('f')],
        ];
    }

    public static function fieldWithDisabledProvider(): array
    {
        return [
            'InputText'   => [InputText::create('f')],
            'InputNumber' => [InputNumber::create('f')],
            'Textarea'    => [Textarea::create('f')],
            'CheckBox'    => [CheckBox::create('f')],
            'SelectBox'   => [SelectBox::create('f')],
        ];
    }

    public static function fieldWithAutofocusProvider(): array
    {
        return [
            'InputText'  => [InputText::create('f')],
            'InputNumber' => [InputNumber::create('f')],
            'Textarea'   => [Textarea::create('f')],
            'CheckBox'   => [CheckBox::create('f')],
            'SelectBox'  => [SelectBox::create('f')],
        ];
    }

    public static function fieldWithPlaceholderProvider(): array
    {
        return [
            'InputText'  => [InputText::create('f')],
            'InputNumber' => [InputNumber::create('f')],
            'Textarea'   => [Textarea::create('f')],
        ];
    }
}
