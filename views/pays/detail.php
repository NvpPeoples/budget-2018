<?php

use yii\helpers\Html;
use app\models\Orgs;
use app\models\Kindergarten;

$this->title = 'Всі платежі';
$this->params['breadcrumbs'][] = [
    'label' => 'Платежі',
    'url'   => ['index']
];
?>

<h2>Платіж №<?= $model->id?> <small>(унікальний ідентифікатор)</small></h2>
<div class="pay-detail lead">
    <dl>
        <dt class="text-muted">Сума</dt>
        <dd class=""><h1><?= Yii::$app->formatter->asCurrency($model->amount)?></h1></dd>
        <dt class="text-muted"><br/>Призначення платежу</dt>
        <dd><strong><?= $model->payment_details?></strong></dd>
    </dl>

    <div class="row">
        <div class="col-sm-4">
            <dl>
                <dt class="text-muted">Дата оплати</dt>
                <dd><strong><?= $model->trans_date?></strong></dd>
            </dl>
        </div>
        <div class="col-sm-4">
            <dl>
                <dt class="text-muted">Дата валютування</dt>
                <dd><strong><?= $model->doc_v_date?></strong></dd>
            </dl>
        </div>
        <div class="col-sm-4">
            <dl>
                <dt class="text-muted">Дата складання</dt>
                <dd><strong><?= $model->doc_date?></strong></dd>
            </dl>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <dl>
                <dt class="text-muted">Код розрахункового документа</dt>
                <dd><strong><?= $model->doc_vob?></strong></dd>
            </dl>
        </div>
        <div class="col-sm-4">
            <dl>
                <dt class="text-muted"></dt>
                <dd></dd>
            </dl>
        </div>
        <div class="col-sm-4">
            <dl>
                <dt class="text-muted">Номер розрахункового документа</dt>
                <dd><strong><?= $model->doc_number?></strong></dd>
            </dl>
        </div>
    </div>

    <div class="row bg-info">
        <div class="col-sm-4">
            <dl>
                <dt class="text-muted">Код платника</dt>
                <dd><strong><?= $model->payer_edrpou?></strong></dd>
            </dl>
        </div>
        <div class="col-sm-4">
            <dl>
                <dt class="text-muted">Найменування платника</dt>
                <dd><strong><?= $model->payer_name?></strong></dd>
            </dl>
        </div>
        <div class="col-sm-4">
            <dl>
                <dt class="text-muted">Рахунок платника</dt>
                <dd><strong><?= $model->payer_account?></strong></dd>
            </dl>
        </div>
    </div>
    <div class="row bg-info">
        <div class="col-sm-4">
            <dl>
                <dt class="text-muted">Код банку платника</dt>
                <dd><strong><?= $model->payer_mfo?></strong></dd>
            </dl>
        </div>
        <div class="col-sm-8">
            <dl>
                <dt class="text-muted">Найменування банку платника</dt>
                <dd><strong><?= $model->payer_bank?></strong></dd>
            </dl>
        </div>
    </div>

    <br/><br/>
    <div class="row bg-success">
        <div class="col-sm-4">
            <dl>
                <dt class="text-muted">Код одержувача</dt>
                <dd><strong><?= $model->recipt_edrpou?></strong></dd>
            </dl>
        </div>
        <div class="col-sm-4">
            <dl>
                <dt class="text-muted">Найменування одержувача</dt>
                <dd><strong><?= $model->recipt_name?></strong></dd>
            </dl>
        </div>
        <div class="col-sm-4">
            <dl>
                <dt class="text-muted">Рахунок одержувача</dt>
                <dd><strong><?= $model->recipt_account?></strong></dd>
            </dl>
        </div>
    </div>
    <div class="row bg-success">
        <div class="col-sm-4">
            <dl>
                <dt class="text-muted">Код банку одержувача</dt>
                <dd><strong><?= $model->recipt_mfo?></strong></dd>
            </dl>
        </div>
        <div class="col-sm-8">
            <dl>
                <dt class="text-muted">Найменування банку одержувача</dt>
                <dd><strong><?= $model->recipt_bank?></strong></dd>
            </dl>
        </div>
    </div>

    <div class="clearfix"></div>
    <br/>
    <?= Html::a('<i class="glyphicon glyphicon-link"></i> посилання транзакції на сайт spending.gov.ua', 'https://spending.gov.ua/spa/37567646/transactions/'.$model->id, [
        'class' => 'btn btn-default'
    ]);?>
</div>
