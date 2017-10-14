<?php
/**
 * Created by PhpStorm.
 * User: nschu
 * Date: 3-6-2017
 * Time: 21:40
 */

namespace Terramania\Terramania\Classes;


use Illuminate\Support\Facades\Request;
use October\Rain\Support\Facades\Config;
use Terramania\Terramania\Models\Theme;

class ThemeService
{
    public function setTheme()
    {
        //Set theme for this session based on hostname
        $requestUrl = Request::url();
        $themes = Theme::all();
        $domain = (new URLParser())->parseDomain($requestUrl)->getRegistrableDomain();
        foreach ($themes as $theme) {
            $bind = (new URLParser())->parseDomain($theme->domain)->getRegistrableDomain();
            if ($domain === $bind) {
                Config::set('cms.activeTheme', $theme->name);
                Config::set('app.url', $domain);
                return $theme->name;
            }
        }
    }

    function setThemeVars()
    {
        $theme = Config::get('cms.activeTheme');
        \Cms\Classes\Theme::setActiveTheme($theme);
    }
}