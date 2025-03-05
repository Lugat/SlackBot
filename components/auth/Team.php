<?php

namespace app\components\auth;

use yii\web\User;

class Team extends User
{
    public $identityClass = 'app\models\Team';
    public $identityCookie = ['name' => '_team', 'httpOnly' => true];
    public $enableAutoLogin = false;
}