<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\StickerPack */

$this->title = 'Update Sticker Pack: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sticker Packs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="sticker-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<br>
<div class="row">

<?php
    $items = [];

    foreach ($model->stickers as $sticker) {
        $url_delete = Url::toRoute(['sticker-pack/deleteimg', 'id_reshenie' => $model->id, 'id_img' => $sticker->id]);

		$item =
            "<div  class=\"thumbnail reshenie_image_form sticker-pos-{$sticker->position}\" data-id=\"{$sticker->id}\">
                <a class=\"btn delete_reshenie_img\" title=\"Удалить?\" href=\"{$url_delete}\" data-id=\"{$sticker->id}\">
                    <span class=\"glyphicon glyphicon-remove\"></span>
                </a>
                <a class=\"fancybox img-rounded\" rel=\"gallery1\" href=\"/{$sticker->filename}\">" .
                    Html::img("/" . $sticker->filename, ['alt' => '', 'style' => "width: 150px; height: 150px;"]) .
                "</a>
            </div>";

		$items []= [
            'content' => $item,
            'options' => [
                'data-id' => $sticker->id,
            ],
        ];
    }

    echo \kartik\sortable\Sortable::widget([
        'type' => 'grid',
        'items' => $items,
        'options' => [
            'data-id' => $model->id
        ],
        'pluginEvents' => [
            'sortupdate' => 'updateStickerPosition',
        ]
    ]);
?>
</div>

<script
        src="https://code.jquery.com/jquery-3.2.1.js"
        integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
        crossorigin="anonymous">
</script>

<script>
    var itemBox = '.reshenie_image_form';       // контейнер записи, id записи храним в data-id
    var $itemDel = $('.delete_reshenie_img');   // ссылка удалить

    $itemDel.click(function(e){
        e.preventDefault();
        var result = confirm('Действительно удалить из базы?');
        if (result) {
            var $this = $(this);
            var $thisItem = $this.closest(itemBox);
            var thisIndex = $thisItem.attr('data-id');
            $.ajax({
                url:'deleteimg' + '?' + $.param({'id_img':thisIndex}),
                type: 'post',
                success:function(r){
                    $thisItem.slideUp(300,function(){
                        $thisItem.parent().remove();
                    });
                }
            });
        }
    });
</script>