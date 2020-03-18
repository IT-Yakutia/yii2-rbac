<?php

namespace ityakutia\rbac;

use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    public $controllerNamespace = 'ityakutia\rbac\controllers';
    
    public function init(){
        parent::init();
    }
}