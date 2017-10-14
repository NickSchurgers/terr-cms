<?php
/**
 * Created by PhpStorm.
 * User: nschu
 * Date: 21-5-2017
 * Time: 12:36
 */

namespace Terramania\Terramania\Controllers;


use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;

class Themes extends Controller
{
    public $implement = ['Backend.Behaviors.ListController', 'Backend.Behaviors.FormController'];
    public $listConfig = 'list_config.yaml';
    public $formConfig = 'form_config.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Terramania.Terramania', 'terramania', 'theme');
    }


    public function index()
    {
        $this->asExtension('ListController')->index();
    }

    public function update($id)
    {
        $this->asExtension('FormController')->update($id);
    }

    public function create()
    {
        $this->asExtension('FormController')->create();
    }

}