<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Прозорі фінанси навчальних закладів';
?>
<div class="site-index">

    <div class="body-content">
<p>
    Всі дані взято із офіційного сайту <?= Html::a('"ЄДИНИЙ ВЕБ-ПОРТАЛ ВИКОРИСТАННЯ ПУБЛІЧНИХ КОШТІВ"', 'https://spending.gov.ua/')?> за 2018 рік.
</p>
        <div class="row">
            <div class="col-lg-4 bg-success">
                <h2>ОТРИМУВАЧІ</h2>

                <div class="text-center" style="font-size:450%"><?= app\models\Orgs::find()->count()?></div>
                <br/>
                <p class="text-center"><?= Html::a('всі організації <i class="glyphicon glyphicon-chevron-right"></i>', ['/orgs'], [
                        'class' => 'btn btn-default'
                    ]);?></p>
            </div>
            <div class="col-lg-8 bg-info">
                <h2>ПЛАТЕЖІ / СУМА ВИТРАТ</h2>

                <div class="text-center" style="font-size:450%"><?= app\models\Pays::find()->count()?> <span class="text-muted">/</span> <?= Yii::$app->formatter->asCurrency(app\models\Pays::find()->select(new \yii\db\Expression('sum(amount)'))->scalar())?></div>
                <br/>
                <p class="text-center"><?= Html::a('всі платежі <i class="glyphicon glyphicon-chevron-right"></i>', ['/pays'], [
                        'class' => 'btn btn-default'
                    ]);?></p>
            </div>
        </div>

        <br/>
        <div class="row">
            <table class="table table-striped table-bordered lead">
                <thead>
                <tr>
                    <th>Напрямок витрат TOP-5</th>
                    <th>Кількість</th>
                    <th>Отримана сума</th>
                </tr>
                </thead>
                <tbody>
                <?foreach($groups as $row):?>
                <tr>
                    <td><i class="fa fa-<?= $row['icon']?>"></i> <?= Html::a($row['name'], ['/types/detail', 'id' => $row['id']])?></td>
                    <td class="text-right"><?= $row['cnt']?></td>
                    <td class="text-right"><?= Yii::$app->formatter->asCurrency($row['amount'])?></td>
                </tr>
                <?endforeach?>
                <tr>
                    <td class="text-right" colspan="3">
                        <?= Html::a('всі напрямки витрат <i class="glyphicon glyphicon-chevron-right"></i>', ['/types'], [
                            'class' => 'btn btn-default'
                        ]);?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>


        <br/>
        <div class="row">
            <table class="table table-striped table-bordered lead">
                <thead>
                <tr>
                    <th>Організація отримувач TOP-10</th>
                    <th>Кількість</th>
                    <th>Отримана сума</th>
                </tr>
                </thead>
                <tbody>
                <?foreach($orgs as $row):?>
                    <tr>
                        <td><?= Html::a($row['name'], ['/orgs/detail', 'id' => $row['id']])?></td>
                        <td class="text-right"><?= $row['cnt']?></td>
                        <td class="text-right"><?= Yii::$app->formatter->asCurrency($row['amount'])?></td>
                    </tr>
                <?endforeach?>
                <tr>
                    <td class="text-right" colspan="3">
                        <?= Html::a('всі напрямки витрат <i class="glyphicon glyphicon-chevron-right"></i>', ['/orgs'], [
                            'class' => 'btn btn-default'
                        ]);?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
