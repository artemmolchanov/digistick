<?php

namespace app\modules\api\controllers;

use app\models\PurchaseForm;
use app\models\EmailForm;
use app\models\StickerPack;
use app\modules\api\filters\ActionTokenFilter;
use Yii;
use yii\base\DynamicModel;
use yii\data\ActiveDataProvider;
use yii\filters\ContentNegotiator;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use yii\httpclient\Client;

/**
 * Class StickerPackController
 *
 * @property mixed httpClient
 * @property mixed secret
 * @package app\modules\api\controllers
 */
class StickerPackController extends Controller
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
     * @return ActiveDataProvider
     */
    public function actionIndex()
    {
        $query = StickerPack::find()->where(['is_active' => 1])->orderBy(['position' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $dataProvider;
    }

    public function actionEmail()
    {
        $form = new EmailForm();

        $form->email = Yii::$app->request->post('email');
        $form->save();

        return $form;
    }

    public function actionPurchase($id)
    {
        $stickerPack = $this->findStickerPack($id);
        $receipt = Yii::$app->request->post('receipt');
        if ($receipt == null) {
            return false;
        }

        if($stickerPack->price == 0){
            $this->addPurchase($id);
            return true;
        }

        $thisStickerpackWasBought = false;

        if (Yii::$app->request->post('platform') != 'android') {
            $thisStickerpackWasBought = $this->checkApplePurchase($id, $receipt);
        } else {
            $thisStickerpackWasBought = $this->checkAndroidPurchase($id, $receipt);
        }

        if ($thisStickerpackWasBought && !PurchaseForm::find()->where(['itemId' => $id, 'token' => $this->getToken()])->one()) {
            $this->addPurchase($id);
        }

        return $thisStickerpackWasBought;
    }

    private function checkApplePurchase($id, $receipt)
    {
        $client = new Client();
        $response = $client->createRequest()
                           ->setMethod('post')
                           ->setHeaders(['content-type' => 'application/json'])
                           ->setContent('{"receipt-data":"'
                                        . $receipt
                                        . '" ,"password":"'
                                        . env('AP_PASWWORD')
                                        . '"}')
                           ->setUrl('https://sandbox.itunes.apple.com/verifyReceipt')
                           ->send();
        $response = json_decode($response->content, true);
        if (empty($response['receipt'])) {
            return false;
        }

        foreach ($response['receipt']['in_app'] as $inApp) {
            if ($inApp['product_id'] == env('APPLE_PURCHASE_PREFIX') . $id) {
                return true;
            }
        }

        return false;
    }

    private function checkAndroidPurchase($id, $receipt)
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . Yii::getAlias('@app/config/google_key/key.json'));
        $client = new \Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(\Google_Service_AndroidPublisher::ANDROIDPUBLISHER);
        $service = new \Google_Service_AndroidPublisher($client);

        try {
            $response = $service->purchases_products->get(
                env('ANDROID_PACKAGE_NAME'),
                env('ANDROID_PURCHASE_PREFIX') . $id,
                $receipt
            );
        } catch (\Exception $e) {
            //TODO log google error
            return false;
        }

        return true;
    }

    protected function addPurchase($id)
    {
        $form = new PurchaseForm();

        $form->itemId = $id;
        $form->token = $this->getToken();
        $form->save();
    }

    public function actionRestorationPurchases()
    {
        $client = new Client();

        $response = $client->createRequest()
                           ->setMethod('post')
                           ->setHeaders(['content-type' => 'application/json'])
                           ->setContent('{"receipt-data":"'.Yii::$app->request->post('receipt').'" ,"password":"'. env('APPLE_PASSWORD') .'"}')
                           ->setUrl('https://sandbox.itunes.apple.com/verifyReceipt')
                           ->send();
        $response = json_decode($response->content, true);
        $all_id = array();

        foreach ($response['receipt']['in_app'] as $inApp) {

            $id = preg_replace("/[^0-9]/", '', $inApp['product_id']);
            array_push($all_id, (int)$id);

            if(PurchaseForm::find()->where(['itemId' => $id, 'token' => $this->getToken()])->one()){
                continue;
            } else {
                $this->addPurchase($id);
            }
        }
        return $all_id;
    }

    protected function getToken()
    {
        return Yii::$app->request->headers->get('Authorization');
    }

    protected function findStickerPack($id)
    {
        $model = StickerPack::findOne(['id' => $id]);
        if ($model === null) {
            throw new NotFoundHttpException('Sticker pack does not exist');
        }

        return $model;
    }
}
