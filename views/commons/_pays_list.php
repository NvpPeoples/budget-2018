<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Region;
?>

<div class="pays-index">

    <?= GridView::widget([
        'dataProvider' => $prov,
        'tableOptions' => ['class' => 'table table-striped'],
        'rowOptions' => function($model, $key, $index, $grid) {
            return '';
        },
        'columns' => [
            [
                'label' => 'Отримувач',
                'format' => 'raw',
                'value' => function($model) {
                    $org = $model->org;
                    return Html::a($org->name, ['/orgs/detail', 'id' => $org->id]);
                }
            ],
            'trans_date',
            [
                'attribute' => 'payment_details'
            ],
            [
                'attribute' => 'amount',
                'contentOptions' => [
                    'class' => 'text-right lead',
                ],
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a(Yii::$app->formatter->asCurrency($model->amount), null, [
                        'href' => 'javascript:void(0);',
                        'class' => 'bn-pay',
                        'data-pay' => $model->id
                    ]);
                }
            ],
        ],
    ]); ?>

</div>
<?php Modal::begin([
    'header' => 'Деталі платежа',
    'size' => Modal::SIZE_LARGE,
    'options' => [
        'id' => 'idModal',
    ]
])?>
<?php Modal::end();?>

<?php
$url_tmpl = Url::to(['/pays/ajax-detail', 'id' => '_id_']);
$this->registerJs($code=<<<EOT
    $(".bn-pay").on("click", function(){
        $("#idModal").modal('show');
        var url = "{$url_tmpl}".replace(/(_id_)/, $(this).data('pay'))
        $("#idModal").find('.modal-body').load(url)
    });
EOT
, View::POS_READY, 'modal');?>
