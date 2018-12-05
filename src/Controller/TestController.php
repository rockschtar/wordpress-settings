<?php
/**
 * Created by PhpStorm.
 * User: Stefan Helmer
 * Date: 27.11.2018
 * Time: 20:01
 */

namespace Rockschtar\WordPress\Settings\Controller;


use Rockschtar\WordPress\Settings\Models\Page;
use Rockschtar\WordPress\Settings\Models\Section;
use Rockschtar\WordPress\Settings\Models\Textfield;
use SebastianBergmann\CodeCoverage\Report\Text;

class TestController extends AbstractSettingsController {

    /**
     * @return Section[]
     */
    public function getSections(): array {
        // TODO: Implement getSections() method.
    }

    public function getPage(): Page {
        // TODO: Implement getPage() method.

        Page::create()->addSection(Section::create()->addField())

    }
}