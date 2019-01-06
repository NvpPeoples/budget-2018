<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Організації';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schools-search">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'],
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
    ]);?>
        <div class="input-group col-sm-12">
            <?= Html::activeInput('text', $search, 'keyword', [
                'class' => 'form-control search-query',
                'placeholder' => 'пошук за назвою організації, ФОП'
            ]);?>
            <span class="input-group-btn">
                <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span>', [
                    'class' => 'btn btn-primary'
                ]);?>
            </span>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<div class="orgs-index">

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
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a($model->name, ['detail', 'id' => $model->id]);
                }
            ],
            [
                'attribute' => 'edrpou',
                'contentOptions' => [
                    'class' => 'text-right',
                ],
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
