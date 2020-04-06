<?php

namespace ityakutia\rbac\models;

use Yii;
use common\models\User as BaseUser;

class User extends BaseUser
{
    public function getPassword()
    {
        return '';
    }
}
