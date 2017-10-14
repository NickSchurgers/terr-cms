<?php
/**
 * Created by PhpStorm.
 * User: nschu
 * Date: 20-5-2017
 * Time: 22:40
 */

namespace Terramania\Terramania\Models;


use Illuminate\Support\Facades\Validator;
use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation;
use Terramania\Terramania\Classes\URLParser;

Validator::extend('domain', function ($attribute, $value, $parameters) {
    return (new URLParser())->validateDomain($value);
});


class Theme extends Model
{
    use Validation;

    protected $table = 'terramania_terramania_themes';

    public $rules = [
        'name' => 'required|unique:terramania_terramania_themes,name',
        'domain' => 'required|unique:terramania_terramania_themes,domain|domain',
    ];

    public $attributeNames = [
        'name' => 'naam',
        'domain' => 'domein',
    ];

    public $customMessages = [
        'domain' => 'Het ingevulde domein is niet geldig'
    ];

    public function getNameOptions($value, $formData)
    {
        $themes = collect(\Cms\Classes\Theme::all());
        $themes = $themes->reject(function ($value) {
            return $value->getDirName() === 'assets';
        })->transform(function ($item) {
            return $item->getConfig();
        })->pluck('name', 'name');
        return array_change_key_case($themes->toArray());

    }
}