<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%team}}".
 *
 * @property string $id
 * @property string $domain
 * @property string $token
 * @property string $bot_token
 */
class Team extends \yii\db\ActiveRecord implements IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%team}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'domain', 'token', 'bot_token'], 'required'],
            [['id'], 'string', 'max' => 16],
            [['domain'], 'string', 'max' => 64],
            [['token', 'bot_token'], 'string', 'max' => 60],
            [['domain'], 'unique'],
            [['token'], 'unique'],
            [['bot_token'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'domain' => Yii::t('app', 'Domain'),
            'token' => Yii::t('app', 'Token'),
            'bot_token' => Yii::t('app', 'Bot Token'),
        ];
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->token;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'team_id']);
    }

    public function getRoutines()
    {
        return $this->hasMany(Routine::class, ['id' => 'team_id']);
    }

}
