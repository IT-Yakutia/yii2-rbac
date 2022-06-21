<?php

namespace ityakutia\rbac\models;

use Yii;
use common\models\User as BaseUser;

class User extends BaseUser
{
    public $password;

    public function getPassword()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['email','username', 'password'], 'required'],

            ['email', 'unique'],
            ['email', 'email'],

            ['username', 'unique'],
            ['username', 'trim'],

            ['password', 'string'],
        ];
    }
}
