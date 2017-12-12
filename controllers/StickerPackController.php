<?php

namespace app\controllers;

use app\models\Sticker;
use app\models\StickerPack;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * StickerPack Controller implements the CRUD actions for StickerPack model.
 */
class StickerPackController extends Controller
{
    public $image;
    public $gallery;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-build' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all StickerPack models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => StickerPack::find()->orderBy(['position' => SORT_ASC]),
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StickerPack model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param $model
     *
     * @return \yii\web\Response
     */
    protected function loadImages($model)
    {
        $model->image = UploadedFile::getInstance($model, 'image');
        if ($model->image) {
            $model->upload();
        }

        $model->gallery = UploadedFile::getInstances($model, 'gallery');
        $model->uploadGallery();

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Creates a new StickerPack model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StickerPack();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->loadImages($model);

            Yii::$app->session->setFlash('success', "Sticker pack created");
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing StickerPack model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->loadImages($model);

            Yii::$app->session->setFlash('success', "Sticker pack updated");
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionSetorder()
    {
        if (!Yii::$app->request->isAjax)
        {
            $this->redirect("/");
        }

        $stickerPackId = Yii::$app->request->post()['sticker_pack'];
        $stickesOrder = Yii::$app->request->post()['order'];

        foreach ($stickesOrder as $orderRecord)
        {
            $sticker = Sticker::findOne(['id' => $orderRecord['id'], 'stickerpack_id' => $stickerPackId]);
            $sticker->moveToPosition($orderRecord['position']);
        }
    }

    /**
     * Deletes an existing StickerPack model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param $id_reshenie
     * @param $id_img
     *
     * @return \yii\web\Response
     */
    public function actionDeleteimg( $id_img)
    {
        $image = Sticker::find()->where(['id' => $id_img])->one();
        $image->delete();

        //return $this->redirect('/sticker-pack/update?id=' . $id_reshenie);
    }

    /**
     * Finds the StickerPack model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return StickerPack the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StickerPack::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Moves sticker pack to previous position in sorting order
     *
     * @param $id
     *
     * @return mixed
     */
    public function actionMoveUp($id)
    {
        $model = $this->findModel($id);

        $model->movePrev();

        return $this->redirect(['index']);
    }

    /**
     * Moves sticker pack to next position in sorting order
     *
     * @param $id
     *
     * @return mixed
     */
    public function actionMoveDown($id)
    {
        $model = $this->findModel($id);

        $model->moveNext();

        return $this->goBack();
    }

    /**
     * Moves sticker pack to given position
     *
     * @param $id
     * @param $position
     *
     * @return mixed
     */
    public function actionSetPosition($id, $position)
    {
        $model = $this->findModel($id);

        $model->moveToPosition($position);

        return $this->goBack();
    }

    public function actionChangeActivity($id)
    {
        $model = StickerPack::findOne($id);
        if ($model !== null) {
            $model->is_active = !$model->is_active;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->redirect(['index']);
        }
    }
}
