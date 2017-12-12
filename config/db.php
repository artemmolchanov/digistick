<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . env('DB_HOST') .  ';dbname=' . env('DB_NAME'),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    'charset' => 'utf8',
];
