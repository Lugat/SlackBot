<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $id
 * @property string $name
 * @property string $first_name
 * @property string $last_name
 * @property string $team_id
 * @property string|null $birthdate
 */
class User extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birthdate'], 'default', 'value' => null],
            [['id', 'name', 'first_name', 'last_name', 'team_id'], 'required'],
            [['birthdate'], 'safe'],
            [['id', 'team_id'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 64],
            [['first_name', 'last_name'], 'string', 'max' => 32],
            [['name'], 'unique'],
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
            'name' => Yii::t('app', 'Name'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'team_id' => Yii::t('app', 'Team ID'),
            'birthdate' => Yii::t('app', 'Birthdate'),
        ];
    }

    public function getTeam()
    {
        return $this->hasOne(Team::class, ['id' => 'team_id']);
    }

}
