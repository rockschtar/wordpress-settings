<?php
/**
 * Created by PhpStorm.
 * User: Stefan Helmer
 * Date: 27.11.2018
 * Time: 19:41
 */

namespace Rockschtar\WordPress\Settings\Tests;

use Rockschtar\WordPress\Settings\Fields\Textfield;
use Rockschtar\WordPress\Settings\Models\Section;
use Rockschtar\WordPress\Settings\Models\SettingsPage;
use WP_Mock;
use WP_Mock\Tools\TestCase;

class WordPressIntegrationTest extends TestCase {

    public function setUp(): void {
        WP_Mock::setUp();

    }

    public function tearDown(): void {
        WP_Mock::tearDown();
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
     * @depends testSettingsPage
     * @param SettingsPage $settingsPage
     */
    public function testTextfield(SettingsPage $settingsPage): void {

        $textField = Textfield::create('ut-testfield')->setLabel('UT Textfield');
        $this->assertStringContainsString('id="ut-testfield" name="ut-testfield"', $textField->output(''));

        $textField->setReadonly(true);
        $this->assertStringContainsString('readonly', $textField->output(''));

        $textField->setPlaceholder('UT Placeholder');
        $this->assertStringContainsString('placeholder="UT Placeholder"', $textField->output(''));

        $this->assertEquals('ut-testfield', $textField->getId());
        $section = $settingsPage->getSections()[0];
        $section->addField($textField);
    }

}