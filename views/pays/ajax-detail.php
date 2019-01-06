<?php

use yii\helpers\Html;
?>

<div class="pay-detail">

    <div class="row">
        <div class="col-sm-6">
            <dl>
                <dt class="text-muted">Унікальний ідентифікатор</dt>
                <dd><strong><?= $model->id?></strong></dd>
            </dl>
        </div>
        <div class="col-sm-6">
            <dl>
                <dt class="text-muted">Дата оплати</dt>
                <dd><strong><?= $model->trans_date?></strong></dd>
            </dl>
        </div>
    </div>

    <dl>
        <dt class="text-muted">Найменування одержувача</dt>
        <dd><strong><?= Html::encode($model->recipt_name)?></strong></dd>
        <dt class="text-muted"><br/>Призначення платежу</dt>
        <dd><strong><?= $model->payment_details?></strong></dd>
    </dl>

    <div class="row">
        <div class="col-sm-6">
            <dl>
                <dt class="text-muted">Сума</dt>
                <dd class="lead"><strong><?= Yii::$app->formatter->asCurrency($model->amount)?></strong></dd>
            </dl>
        </div>
        <div class="col-sm-6">
            <dl>
                <dt class="text-muted">Код платника</dt>
                <dd><strong><?= Html::encode($model->recipt_edrpou)?></strong></dd>
                <dt class="text-muted">Рахунок платника</dt>
                <dd><strong><?= Html::encode($model->recipt_account)?></strong></dd>

            </dl>
        </div>
    </div>
    <div class="clearfix"></div>
    <?= Html::a('<i class="glyphicon glyphicon-link"></i> постійне посилання із деталізацією даних', ['link', 'id' => $model->id], [
        'class' => 'btn btn-default pull-right'
    ]);?>
    <div class="clearfix"></div>

</div>
