<?php
use common\components\SqliteCommand;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'as log' => \yii\queue\LogBehavior::class,
            'path' => '@backend/runtime/queue',
        ],
        'sqliteCommand' => [
          'class'  => SqliteCommand::class,
        ],
    ],
    'bootstrap' => ['log', 'queue'],
];
