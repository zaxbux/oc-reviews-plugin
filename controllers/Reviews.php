<?php namespace Zaxbux\Reviews\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Reviews extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'manage_reviews' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Zaxbux.Reviews', 'main-menu-item');
    }
}
