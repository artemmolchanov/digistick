<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sticker Packs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sticker-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Sticker Pack', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'app\helpers\grid\PositionColumn',
                'buttons' => [

                    'move-up' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', $url, [
                            'style' => 'margin-right:15px'
                        ]);
                    },

                    'move-down' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', $url, [
                            'style' => 'margin-right:15px'
                        ]);
                    },
                ],
            ],
            'name',
            'price',
            ['class' => 'yii\grid\ActionColumn',

                'buttons' => [

            //view button
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'style' => 'margin-right:15px'
                        ]);
                    },

                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'style' => 'margin-right:15px'
                        ]);
                    },
                ],

            ],
        ],
    ]); ?>

    <?php
    yii\bootstrap\Modal::begin([
        'id' =>'modal',
        'header' => '<h4>Set new position </h4>',
    ]);?>
    <form class="update-position-form form-inline" action="<?= \yii\helpers\Url::to('/sticker-pack/set-position')?>">
        <div class="form-group">
            <input class="destination-stickerpack-id" type="hidden" name="id">
            <div class="input-group">
                <div class="input-group-addon">#</div>
                <input type="text" name="position" class="form-control" placeholder="1">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Set</button>
    </form>
    <?php yii\bootstrap\Modal::end(); ?>
</div>
