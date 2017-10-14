<?php
/**
 * Created by PhpStorm.
 * User: nschu
 * Date: 21-5-2017
 * Time: 14:23
 */

namespace Terramania\Terramania\Classes;


use LayerShifter\TLDExtract\Extract;

class URLParser
{

    public function validateDomain($domain)
    {
        return $this->parseDomain($domain)->isValidDomain();
    }

    public function parseDomain($fqdn)
    {
        return (new Extract(null, null, Extract::MODE_ALLOW_ICCAN | Extract::MODE_ALLOW_PRIVATE))->parse($fqdn);
    }
}