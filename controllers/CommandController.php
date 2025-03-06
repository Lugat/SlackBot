<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;

use app\models\User;
use app\components\auth\BodyParamAuth;
use app\components\auth\TeamAccessControl;
use app\components\slack\commands\AbstractCommand;

class CommandController extends Controller
{

    protected ?AbstractCommand $command = null;

    public function init()
    {

        parent::init();
    
        Yii::$app->response->format = Response::FORMAT_JSON;

    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => BodyParamAuth::class,
            ],
            'access' => [
                'class' => TeamAccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['index'],
                ],
            ],
        ];
    }

    protected function arrayToString(array $data, string $glue = ', ', string $seperator = ': '): string
    {

        $result = [];

        foreach ($data as $key => $value) {
            if (is_string($key)) {
                $result[] = "{$key}{$seperator}{$value}";
            } else {
                $result[] = (string) $value;
            }
        }
        
        return implode($glue, $result);

    }

    public function afterAction($action, $result)
    {

        $result = parent::afterAction($action, $result);

        if (is_array($result)) {
            $result = $this->arrayToString($result, "\n");
        }

        $params = Yii::$app->request->getBodyParams();

        return array_filter([
            'response_type' => $this->command->responseType,
            'text' => strtr($result, [
                '{user}' => $params['user_name'],
                '{channel}' => $params['channel_name'],
                '{team}' => $params['team_domain']
            ])
        ]);
        
    }

    public function beforeAction($action) : bool
    {

        $params = Yii::$app->request->getBodyParams();

        $user = User::findOne($params['user_id']);
        if (null !== $user) {
            Yii::$app->user->login($user);
        }

        return parent::beforeAction($action);

    }

    public function actionIndex()
    {

        $params = Yii::$app->request->getBodyParams();

        $this->command = Yii::$app->slack->getCommand($params['command']);
        if (null === $this->command) {

            return Yii::t('app', 'Command "{command}" not found.', [
                'command' => $params['command']
            ]);

        }

        if (!$this->command->canExecute()) {

            return Yii::t('app', 'You are not allowed to execute "{command}".', [
                'command' => $params['command']
            ]);

        }

        return $this->command->execute($params['text']);

    }

}