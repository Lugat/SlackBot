<?php

return [
    'class' => 'yii\queue\db\Queue',
    'db' => 'db',
    'tableName' => '{{%queue}}',
    'channel' => 'default',
    'mutex' => 'yii\mutex\MysqlMutex'
];