<?php namespace Terramania\Terramania;

use Backend\Facades\Backend;
use Backend\FormWidgets\RichEditor;
use Cms\Models\ThemeData;
use Cms\Models\ThemeImport;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use October\Rain\Support\Facades\Config;
use System\Classes\CombineAssets;
use System\Classes\PluginBase;
use Terramania\Terramania\Classes\ThemeService;
use Terramania\Terramania\Classes\URLParser;
use Terramania\Terramania\Models\Theme;


/**
 * Terramania Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Terramania',
            'description' => 'Plugin voor informatieve website\'s van Terramania',
            'author' => 'Nick Schürgers',
            'icon' => 'icon-pencil-square-o'
        ];
    }

    public function registerMarkupTags()
    {
        return [
            'functions' => [

                // Using an inline closure
                'host' => [$this, 'getHostName'],
                'fullHost' => [$this, 'getFullHostName'],
                'sanitize' => [$this, 'getSanitize'],
            ]
        ];
    }


    private function __parseDomain()
    {

        //Return hostname based on currently active theme
        if (!$theme = Theme::where('name', Config::get('cms.activeTheme'))->first()) {
            return false;
        }
        return (new URLParser())->parseDomain($theme->domain);
    }

    public function getHostName()
    {
        return $this->__parseDomain()->getHostname();
    }


    public function getFullHostName()
    {
        return $this->__parseDomain()->getFullHost();
    }

    public function getSanitize($string)
    {
        return preg_replace("/[^A-Za-z0-9]/", "", $string);;
    }

    public function boot()
    {
        $themeService = new ThemeService();

        //Without this bit of code, scss assetVars wont reflect the theme active for this session and will use the assetVars from the theme selected in the backend
        //Switches backend theme to the one used for this session. Enable asset caching to avoid db updates each request
        Event::listen('cms.combiner.beforePrepare', function ($combiner, $assets) use ($themeService) {
            $themeService->setThemeVars();
        });

        Event::listen('cms.theme.getActiveTheme', function () use ($themeService) {
            return $themeService->setTheme();
        });

        RichEditor::extend(function($widget) {
           $widget->addJs('/themes/assets/js/froala.js');
           $widget->addJs('/themes/assets/node_modules/foundation-sites/dist/js/foundation.min.js');
           $widget->addCss('/themes/assets/node_modules/foundation-sites/dist/css/foundation.min.css');
           $widget->addCss('/themes/assets/css/styles.css');
        });

    }


    public function registerNavigation()
    {
        return [
            'terramania' => [
                'label' => 'Terramania',
                'url' => Backend::url('terramania/terramania/themes'),
                'icon' => 'icon-pencil',
                'order' => 500,

                'sideMenu' => [
                    'themes' => [
                        'label' => 'Thema\'s',
                        'icon' => 'icon-pencil',
                        'url' => Backend::url('terramania/terramania/themes')
                    ]
                ]
            ]
        ];
    }


}
