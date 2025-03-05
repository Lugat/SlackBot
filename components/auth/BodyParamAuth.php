<?php

namespace app\components\auth;

use Yii;
use yii\filters\auth\AuthMethod;

class BodyParamAuth extends AuthMethod
{

    public string $tokenParam = 'token';

    public function beforeAction($action): bool
    {

        $this->user = Yii::$app->team;

        return parent::beforeAction($action);

    }    

    public function authenticate($team, $request, $response)
    {

        $accessToken = $request->getBodyParam($this->tokenParam);

        if (is_string($accessToken)) {

            $identity = $team->loginByAccessToken($accessToken, get_class($this));
            
            if (null !== $identity) {
                return $identity;
            }

        }

        if (null !== $accessToken) {
            $this->handleFailure($response);
        }

        return null;
        
    }
}