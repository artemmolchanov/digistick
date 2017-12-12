<?php

namespace app\modules\api\controllers;

use app\models\Token;
use Yii;

/**
 * Class TokenController
 *
 * @package app\modules\api\controllers
 */
class TokenController extends Controller
{
    /**
     * @return mixed|string
     */
    public function actionCreate()
    {
        $token = new Token();

        $token->token = Yii::$app->security->generateRandomString(64);
        $token->save();

        return $token->token;
    }
}