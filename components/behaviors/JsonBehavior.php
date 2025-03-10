<?php

namespace app\components\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class JsonBehavior extends Behavior
{

    public $fields = [];

    public $jsonOptions = JSON_UNESCAPED_UNICODE;

    public $defaultValue = '[]';

    public $skipEmpty = true;

    public $asArray = true;

    public function events(): array
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => [$this, 'decodeFields'],
            ActiveRecord::EVENT_AFTER_INSERT => [$this, 'decodeFields'],
            ActiveRecord::EVENT_AFTER_UPDATE => [$this, 'decodeFields'],
            ActiveRecord::EVENT_BEFORE_INSERT => [$this, 'encodeFields'],
            ActiveRecord::EVENT_BEFORE_UPDATE => [$this, 'encodeFields'],
        ];
    }

    public function decodeFields(): void
    {
        foreach ($this->fields as $field) {
            $this->owner->{$field} = json_decode($this->owner->{$field} ?: '{}', $this->asArray);
        }
    }

    public function encodeFields(): void
    {

        foreach ($this->fields as $field) {

            $value = $this->owner->{$field};
            if ($this->skipEmpty && null === $value) {
                continue;
            }

            if (empty($value)) {
                $value = is_string($this->defaultValue) ? $this->defaultValue : json_encode($this->defaultValue, $this->jsonOptions);
            } else {
                $value = json_encode($value, $this->jsonOptions);
            }

            $this->owner->{$field} = $value;

        }

    }
    
}