<?php
/**
 * Created by PhpStorm.
 * User: Stefan Helmer
 * Date: 27.11.2018
 * Time: 19:41
 */

namespace Rockschtar\WordPress\Settings\Tests;

use Brain\Monkey\Functions;
use PHPUnit\Framework\TestCase;
use Rockschtar\WordPress\Settings\Fields\CheckBox;
use Rockschtar\WordPress\Settings\Fields\SelectBox;
use Rockschtar\WordPress\Settings\Fields\Textarea;
use Rockschtar\WordPress\Settings\Fields\InputText;
use Rockschtar\WordPress\Settings\Models\Datalist;
use Rockschtar\WordPress\Settings\Models\Field;
use Rockschtar\WordPress\Settings\Models\Section;
use Rockschtar\WordPress\Settings\Models\SelectBoxItem;
use Rockschtar\WordPress\Settings\Models\SettingsPage;
use function Brain\Monkey\setUp;
use function Brain\Monkey\tearDown;


class SettingsPageTest extends TestCase {

    public function setUp(): void {
        setUp();

    }

    public function tearDown(): void {
        tearDown();
    }

    /**
     * @covers \Rockschtar\WordPress\Settings\Models\SettingsPage
     * @return SettingsPage
     */
    public function testSettingsPage(): SettingsPage {

        $settingsPage = SettingsPage::create('ut-settingspage')
                                    ->setPageTitle('Unit Test Page Title')
                                    ->setCapability('manage_options')
                                    ->setMenuTitle('Unit Test Menu Title');

        $this->assertEquals('ut-settingspage', $settingsPage->getId());

        return $settingsPage;
    }

    /**
     * @depends testSettingsPage
     * @covers  \Rockschtar\WordPress\Settings\Models\Section
     * @covers  \Rockschtar\WordPress\Settings\Models\SettingsPage::addSection
     * @param SettingsPage $settingsPage
     * @return SettingsPage
     */
    public function testSection(SettingsPage $settingsPage): SettingsPage {
        $section = Section::create('ut-section');
        $this->assertEquals('ut-section', $section->getId());
        $settingsPage->addSection($section);
        return $settingsPage;
    }

    /**
     * @depends testSection
     * @param SettingsPage $settingsPage
     */
    public function testTextfield(SettingsPage $settingsPage): void {

        $textField = InputText::create('ut-testfield')->setLabel('UT Textfield');
        $this->assertStringContainsString('id="ut-testfield" name="ut-testfield"', $textField->processOutput(''));

        $this->assertAutofocus($textField);
        $this->assertReadonly($textField);
        $this->assertDisabled($textField);
        $this->assertPlaceholder($textField);
        $this->assertDescription($textField);

        $this->assertStringContainsString('<input type="text"', $textField->processOutput(''));

        $textField->setType(InputText::COLOR);
        $this->assertStringContainsString('<input type="color"', $textField->processOutput(''));

        $textField->setType(InputText::PASSWORD);
        $this->assertStringContainsString('<input type="password"', $textField->processOutput(''));

        $textField->setType(InputText::DATE);
        $this->assertStringContainsString('<input type="date"', $textField->processOutput(''));

        $textField->setType(InputText::EMAIL);
        $this->assertStringContainsString('<input type="email"', $textField->processOutput(''));

        $textField->setType(InputText::TEXT);
        $this->assertStringContainsString('<input type="text"', $textField->processOutput(''));

        $textField->setDatalist(Datalist::create('data-list', ['item1']));
        $this->assertStringContainsString('<datalist id="data-list"><option value="item1"></datalist>', $textField->processOutput(''));

        $textField->setLabel('Textfield');

        $section = $settingsPage->getSections()[0];
        $section->addField($textField);
    }

    /**
     * @depends testSection
     * @param SettingsPage $settingsPage
     */
    public function testCheckbox(SettingsPage $settingsPage): void {

        $checkbox = CheckBox::create('ut-testfield')->setLabel('UT Textfield');
        $this->assertStringContainsString('id="ut-testfield" name="ut-testfield"', $checkbox->processOutput(''));

        $checkbox->setReadonly(true);
        $this->assertStringContainsString('onclick="return false;"', $checkbox->processOutput(''));

        $this->assertAutofocus($checkbox);
        $this->assertDisabled($checkbox);
        $this->assertDescription($checkbox);

        $checkbox->setLabel('Checkbox');
        $section = $settingsPage->getSections()[0];
        $section->addField($checkbox);
    }


    /**
     * @depends testSection
     * @param SettingsPage $settingsPage
     */
    public function testSelectbox(SettingsPage $settingsPage): void {

        $selectbox = SelectBox::create('ut-selectbox')->setLabel('UT Textfield');
        $this->assertStringContainsString('id="ut-selectbox"', $selectbox->processOutput(''));
        $this->assertStringContainsString('name="ut-selectbox"', $selectbox->processOutput(''));

        $selectbox->addItem(new SelectBoxItem('hello', 'world', true));
        $selectbox->addItem(new SelectBoxItem('value', 'item', true));

        Functions\expect('selected')->with('hello')->andReturn(false);
        Functions\expect('disabled')->andReturn(false);

        $output = $selectbox->processOutput('');


        $this->assertAutofocus($selectbox);
        $this->assertDisabled($selectbox);
        $this->assertDescription($selectbox);

        $selectbox->setLabel('Checkbox');
        $section = $settingsPage->getSections()[0];
        $section->addField($selectbox);
    }

    /**
     * @depends testSection
     * @param SettingsPage $settingsPage
     */
    public function testTextarea(SettingsPage $settingsPage): void {

        $textarea = Textarea::create('ut-textarea')->setLabel('UT Textarea');
        $this->assertStringContainsString('id="ut-textarea" name="ut-textarea"', $textarea->processOutput(''));

        $this->assertReadonly($textarea);
        $this->assertDisabled($textarea);
        $this->assertAutofocus($textarea);
        $this->assertPlaceholder($textarea);
        $this->assertDescription($textarea);

        $textarea->setRows(20);
        $this->assertStringContainsString('rows="20"', $textarea->processOutput(''));

        $textarea->setCols(40);
        $this->assertStringContainsString('cols="40"', $textarea->processOutput(''));

        $textarea->setDirname(true);
        $this->assertStringContainsString('dirname="' . $textarea->getId() . '.dir"', $textarea->processOutput(''));

        $textarea->setLabel('Checkbox');
        $section = $settingsPage->getSections()[0];
        $section->addField($textarea);
    }

    private function assertReadonly(Field $field): void {

        if (method_exists($field, 'setReadonly')) {
            $field->setReadonly(true);
            $this->assertStringContainsString(' readonly', $field->processOutput(''));
        } else {
            $this->assertTrue(false);
        }
    }

    private function assertDisabled(Field $field): void {

        if (method_exists($field, 'setDisabled')) {
            $field->setDisabled(true);
            $this->assertStringContainsString(' disabled', $field->processOutput(''));
        } else {
            $this->assertTrue(false);
        }
    }

    private function assertAutofocus(Field $field): void {

        if (method_exists($field, 'setAutofocus')) {
            $field->setAutofocus(true);
            $this->assertStringContainsString(' autofocus', $field->processOutput(''));
        } else {
            $this->assertTrue(false);
        }
    }

    private function assertDescription(Field $field): void {

        $field->setDescription('Description');
        $this->assertStringContainsString('<p class="description">Description</p>', $field->processOutput(''));
    }

    private function assertPlaceholder(Field $field): void {

        if (method_exists($field, 'setPlaceholder')) {
            $field->setPlaceholder('UT Placeholder');
            $this->assertStringContainsString('placeholder="UT Placeholder"', $field->processOutput(''));
        } else {
            $this->assertTrue(false);
        }
    }

}
