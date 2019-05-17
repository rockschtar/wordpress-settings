<?php
/**
 * Created by PhpStorm.
 * User: Stefan Helmer
 * Date: 27.11.2018
 * Time: 19:41
 */

namespace Rockschtar\WordPress\Settings\Tests;

use Brain\Monkey\Expectation\FunctionStub;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Rockschtar\WordPress\Settings\Fields\Textfield;
use Rockschtar\WordPress\Settings\Models\Section;
use Rockschtar\WordPress\Settings\Models\SettingsPage;
use function Brain\Monkey\Functions\stubs;
use function Brain\Monkey\setUp;
use function Brain\Monkey\tearDown;

class SuperTest extends TestCase {

    use MockeryPHPUnitIntegration;

    public function setUp() {
        parent::setUp();
        setUp();

    }

    public function tearDown() {
        tearDown();
        parent::tearDown();
    }

    public function testAbstractFieldList() : void {

        $page = SettingsPage::create('ut-settingspage');

        $a = new Section();

        $a->addField(Textfield::create('ut-testfield')->setDefaultOption('Hello World'));

        $alalal = has_filter('default_option_' . 'ut_testfield');

        $a = get_option('ut-testfield');

        $this->assertEquals(1, 1);

    }

}