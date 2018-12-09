<?php
/**
 * Created by PhpStorm.
 * User: Stefan Helmer
 * Date: 27.11.2018
 * Time: 19:41
 */

namespace Rockschtar\WordPress\Settings\Tests;


use PHPUnit\Framework\TestCase;
use Rockschtar\WordPress\Settings\Models\Section;
use Rockschtar\WordPress\Settings\Models\SettingsPage;
use Rockschtar\WordPress\Settings\Models\Textfield;

class SuperTest extends TestCase {


    public function testAbstractFieldList() : void {

        $x = new SettingsPage();

         $a = new Section();

        $a->addField(new Textfield());


    }

}