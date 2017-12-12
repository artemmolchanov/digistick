<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Sticker */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sticker Packs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if (Yii::$app->session->hasFlash('success')): ?>

    <div class="alert alert-success alert-dismissable">

        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-check"></i>Saved!</h4>

        <?= Yii::$app->session->getFlash('success') ?>

    </div>
<?php endif ?>
<div class="sticker-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <p> <h4 style="display: inline">Activity: <?= $model->is_active ? "Active" : "Not Active" ?></h4>
        <?php
        $btnText = $model->is_active ? "Deactivate" : "Activate";
        $btnClass = $model->is_active ? "btn-warning" : "btn-success";
        echo Html::a($btnText, ['change-activity', 'id' => $model->id], ['class' => 'btn ' . $btnClass])
        ?>
    </p>
    <h4>Price: <?= $model->price == 0 ? "Free" : $model->price . " $" ?></h4>
    <h4>Store purchase ID:</h4>
    <div class="panel panel-info">
        <div class="panel-heading">
            iOS
        </div>
        <div class="panel-body"><?= env('APPLE_PURCHASE_PREFIX') . $model->id ?></div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            Android
        </div>
        <div class="panel-body"><?= env('ANDROID_PURCHASE_PREFIX') . $model->id ?></div>
    </div>
    <h4>Description: </h4><?= $model->description ?>

    <h4>Stickers:</h4>
    <div class="row" >
        <?php
        foreach ($model->stickers as $sticker): ?>
            <div class="col-md-2">
                <?= Html::img("/" . $sticker->filename, ['alt' => $model->name, 'class' => "img-thumbnail", 'style' => "width: 150px; height: 150px;"]) ?>
            </div>
        <?php endforeach; ?>
    </div>

</div>
