<?php

return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            //'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            'dsn' => 'mysql:host=mysql;dbname=test_yii2',
            'username' => 'root',
            'password' => '1hHpfA%ew1',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
        ],
    ],
];
