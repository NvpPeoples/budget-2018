<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Напрямок витрат коштів';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-index">

    <h1><?= Html::encode($this->title)?> отримувачі коштів</h1>

    <?= GridView::widget([
        'dataProvider' => $prov,
        'tableOptions' => ['class' => 'table table-striped'],
        'rowOptions' => function($model, $key, $index, $grid) {
            return '';
        },
        'columns' => [
            [
                'attribute' => 'name',
                'contentOptions' => [
                    'class' => 'lead',
                ],
                'format' => 'raw',
                'value' => function($model) {
                    return '<i class="fa fa-'.$model->icon.'"></i> '.Html::a($model->name, ['detail', 'id' => $model->id]);
                }
            ],
            [
                'attribute' => 'groupCnt',
                'label' => 'Платежів',
                'contentOptions' => [
                    'class' => 'text-right lead',
                ],
                'format' => 'raw',
                'value' => function($model) {
                    return $model->getCntOfPays();
                }
            ],
            [
                'attribute' => 'groupSumm',
                'label' => 'На суму',
                'contentOptions' => [
                    'class' => 'text-right lead',
                ],
                'format' => 'currency',
                'value' => function($model) {
                    return $model->getSummOfPays();
                }
            ],
        ],
    ]); ?>

</div>
