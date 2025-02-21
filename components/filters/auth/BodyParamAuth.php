<?php

namespace app\components\filters\auth;

use yii\filters\auth\AuthMethod;

class BodyParamAuth extends AuthMethod
{
    public string $tokenParam = 'token';

    public function authenticate($user, $request, $response)
    {

        $accessToken = $request->getBodyParam($this->tokenParam);
        if (is_string($accessToken)) {
            $identity = $user->loginByAccessToken($accessToken, get_class($this));
            if ($identity !== null) {
                return $identity;
            }
        }
        if ($accessToken !== null) {
            $this->handleFailure($response);
        }

        return null;
    }
}