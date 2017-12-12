<?php

namespace app\modules\api\controllers;

use yii\filters\ContentNegotiator;
use yii\web\Response;

/**
 * Class Controller
 *
 * @package app\modules\api\controllers
 */
abstract class Controller extends \yii\rest\Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }
}
