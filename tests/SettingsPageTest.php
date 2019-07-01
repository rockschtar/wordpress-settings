<?php
/**
 * Created by PhpStorm.
 * User: Stefan Helmer
 * Date: 27.11.2018
 * Time: 19:41
 */

namespace Rockschtar\WordPress\Settings\Tests;

use function Brain\Monkey\setUp;
use function Brain\Monkey\tearDown;
use PHPUnit\Framework\TestCase;
use Rockschtar\WordPress\Settings\Fields\CheckBox;
use Rockschtar\WordPress\Settings\Fields\Textfield;
use Rockschtar\WordPress\Settings\Models\Datalist;
use Rockschtar\WordPress\Settings\Models\Section;
use Rockschtar\WordPress\Settings\Models\SettingsPage;


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

        $textField = Textfield::create('ut-testfield')->setLabel('UT Textfield');


        $this->assertStringContainsString('id="ut-testfield" name="ut-testfield"', $textField->output(''));

        $textField->setReadonly(true);
        $this->assertStringContainsString('readonly', $textField->output(''));

        $textField->setPlaceholder('UT Placeholder');
        $this->assertStringContainsString('placeholder="UT Placeholder"', $textField->output(''));

        $textField->setDescription('Description');
        $this->assertStringContainsString('<p class="description">Description</p>', $textField->output(''));

        $this->assertStringContainsString('<input type="text"', $textField->output(''));

        $textField->setType(Textfield::COLOR);
        $this->assertStringContainsString('<input type="color"', $textField->output(''));

        $textField->setType(Textfield::PASSWORD);
        $this->assertStringContainsString('<input type="password"', $textField->output(''));

        $textField->setType(Textfield::DATE);
        $this->assertStringContainsString('<input type="date"', $textField->output(''));

        $textField->setType(Textfield::EMAIL);
        $this->assertStringContainsString('<input type="email"', $textField->output(''));

        $textField->setType(Textfield::TEXT);
        $this->assertStringContainsString('<input type="text"', $textField->output(''));

        $textField->setDatalist(Datalist::create('data-list', ['item1']));
        $this->assertStringContainsString('<datalist id="data-list"><option value="item1"></datalist>', $textField->output(''));

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


        $this->assertStringContainsString('id="ut-testfield" name="ut-testfield"', $checkbox->output(''));

        $checkbox->setReadonly(true);
        $this->assertStringContainsString('onclick="return false;"', $checkbox->output(''));


        $checkbox->setDescription('Description');
        $this->assertStringContainsString('<p class="description">Description</p>', $checkbox->output(''));

        $checkbox->setLabel('Textfield');

        $section = $settingsPage->getSections()[0];
        $section->addField($checkbox);
    }
}