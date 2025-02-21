<?php

namespace app\models;

use Yii;

use Cron\CronExpression;
use app\components\slack\MessageJob;

/**
 * This is the model class for table "{{%routine}}".
 *
 * @property int $id
 * @property string $team_id
 * @property string $class
 * @property string $timezone
 * @property string $expression
 * @property string $config
 */
class Routine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%routine}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['team_id', 'class', 'timezone', 'expression', 'config'], 'required'],
            [['config'], 'string'],
            [['team_id'], 'string', 'max' => 16],
            [['class'], 'string', 'max' => 128],
            [['channel', 'timezone', 'expression'], 'string', 'max' => 32],
            [['team_id', 'channel', 'class', 'timezone', 'expression'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'team_id' => Yii::t('app', 'Team ID'),
            'channel' => Yii::t('app', 'Channel'),
            'class' => Yii::t('app', 'Class'),
            'timezone' => Yii::t('app', 'Timezone'),
            'expression' => Yii::t('app', 'Expression'),
            'config' => Yii::t('app', 'Config'),
        ];
    }

    public function getIsDue()
    {

        $date = new \DateTime;
        $date->setTimezone(new \DateTimeZone($this->timezone));

        return CronExpression::factory($this->expression)->isDue($date);

    }

    public function execute(bool $queue = true): void
    {

        $routine = Yii::createObject(array_merge(
            ['class' => $this->class],
            json_decode($this->config, true)
        ));

        if (null !== $routine) {

            $message = $routine->execute();

            var_dump($message);
            exit();

            if (null === $message) {
                return;
            }

            $job = new MessageJob([
                'teamId' => $this->team->id,
                'channel' => $this->channel,
                'message' => $message,
            ]);

            if (true === $queue) {
                Yii::$app->queue->push($job);
            } else {
                $job();
            }

        }

    }

    public function getTeam()
    {
        return $this->hasOne(Team::class, ['id' => 'team_id']);
    }

}
