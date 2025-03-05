<?php

namespace app\components\auth;

use yii\filters\AccessControl;

class TeamAccessControl extends AccessControl
{
    public $user = 'team';
}