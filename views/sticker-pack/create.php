<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StickerPack */

$this->title = 'Create Sticker Pack';
$this->params['breadcrumbs'][] = ['label' => 'Sticker Packs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sticker-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
