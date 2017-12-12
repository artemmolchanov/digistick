<?php

namespace app\modules\api\controllers;

use app\models\PurchaseForm;
use app\models\StickerPack;
use app\modules\api\filters\ActionTokenFilter;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\ContentNegotiator;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class StickerController
 *
 * @package app\modules\api\controllers
 */
class StickerController extends Controller
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
            'tokenFilter' => [
                'class' => ActionTokenFilter::className(),
            ],
        ];
    }

    /**
     * @param integer $id
     *
     * @return ActiveDataProvider
     * @throws NotFoundHttpException
     */
    public function actionIndex($id)
    {
        $stickerPack = $this->findStickerPack($id);

        if (!PurchaseForm::find()->where(['itemId' => $id, 'token' => Yii::$app->request->headers->get('Authorization')])->one()) {
            throw new NotFoundHttpException('Purchase not found');
        }

        $query = $stickerPack->getStickers();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $dataProvider;
    }

    /**
     * @param integer $id
     *
     * @return StickerPack
     * @throws NotFoundHttpException
     */
    protected function findStickerPack($id)
    {
        $model = StickerPack::findOne(['id' => $id]);
        if ($model === null) {
            throw new NotFoundHttpException('Sticker pack does not exist');
        }

        return $model;
    }

}
