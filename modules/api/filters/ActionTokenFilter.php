<?php

namespace app\modules\api\filters;

use app\models\Token;
use Yii;
use yii\base\ActionFilter;
use yii\web\BadRequestHttpException;

/**
 * Class ActionTokenFilter
 *
 * @package app\modules\api\filters
 */
class ActionTokenFilter extends ActionFilter
{
    /**
     * @param \yii\base\Action $action
     *
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $token = $this->getToken();
        $exist = Token::find()->where(['token' => $token])->exists();
        if (!$exist) {
            throw new BadRequestHttpException('Such a token does not exist');
        }
        return true;
    }

    /**
     * @return array|string
     * *
     * @throws BadRequestHttpException
     */
    protected function getToken()
    {
        $token = Yii::$app->getRequest()->getHeaders()->get('Authorization');
        if (empty($token)) {
            throw new BadRequestHttpException('Token is required');
        }

        return $token;
    }
}
