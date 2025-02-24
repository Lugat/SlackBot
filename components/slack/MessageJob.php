<?php

  namespace app\components\slack;
  
  use Yii;
  use yii\base\BaseObject;
  use yii\queue\JobInterface;
  
  use app\models\Team;
  
  class MessageJob extends BaseObject implements JobInterface
  {
    
    public string $teamId;   
    public string $channel;
    public array|string $message; 

    public function execute($queue)
    {
        $this->__invoke();
    }

    public function __invoke()
    {

        $team = Team::findOne($this->teamId);
        if (null !== $team) {
            Yii::$app->user->login($team);
            Yii::$app->slack->sendMessage($this->channel, $this->message);
        }

    }
    
  }