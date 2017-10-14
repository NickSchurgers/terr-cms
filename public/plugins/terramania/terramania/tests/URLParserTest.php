<?php
/**
 * Created by PhpStorm.
 * User: nschu
 * Date: 21-5-2017
 * Time: 14:23
 */

namespace Terramania\Terramania\Tests;


use PluginTestCase;
use Terramania\Terramania\Classes\URLParser;

class URLParserTest extends PluginTestCase
{

    public function testValidateDomain()
    {
        $parser = new URLParser();
        $domain = 'schildpad.info';

        $result = $parser->validateDomain($domain);
        $this->assertTrue($result);
    }

    public function testInvalidDomain()
    {
        $parser = new URLParser();
        $domain = 'schildpad.inf/index';

        $result = $parser->validateDomain($domain);
        $this->assertFalse($result);
    }
}