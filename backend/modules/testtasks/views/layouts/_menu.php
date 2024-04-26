<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

    NavBar::begin([
        'options' => [
            'class' => 'navbar navbar-expand navbar-expand-lg navbar-light bg-light',
        ],
    ]);
    $menuItems = [
        ['label' => 'Author', 'url' => ['/testtasks/author/index']],
        ['label' => 'Book', 'url' => ['/testtasks/book/index'], 'visible' => !Yii::$app->user->isGuest],
        ['label' => 'Report', 'url' => ['/testtasks/book/report-most-year'], 'visible' => !Yii::$app->user->isGuest],
        ['label' => 'SubscriberAuthor', 'url' => ['/testtasks/subscriber-author/index'], 'visible' => !Yii::$app->user->isGuest],
    ];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-1'],
        'items' => $menuItems,
    ]);
   
    NavBar::end();
    
    
