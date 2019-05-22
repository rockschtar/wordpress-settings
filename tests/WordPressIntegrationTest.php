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
use WP_Mock\Tools\TestCase;

class WordPressIntegrationTest extends TestCase {

    public function setUp(): void {
        \WP_Mock::setUp();

    }

    public function tearDown(): void {
        \WP_Mock::tearDown();
    }

    public function testSettingsPage() {

        $page = SettingsPage::create('ut-settingspage')->setPageTitle('Unit Test Page Title');

        $section = Section::create('ut-section');

        $this->assertEquals('ut-settingspage', $page->getId());


    }

    public function testTextfield(): void {

        $textField = Textfield::create('ut-testfield');

        $this->assertEquals('ut-testfield', $textField->getId());

        \WP_Mock::expectFilter('rwps-field-html');

        //\WP_Mock::expectFilter('rwps-field-html');

        $output = $textField->output('Hello World');

        $this->assertHooksAdded();



    }

}