<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Region;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Напрямок витрат';
$this->params['breadcrumbs'][] = [
    'label' => 'Напрямок витрат',
    'url'   => ['index']
];
HighchartsAsset::register($this)->withScripts(['highcharts-more', 'modules/solid-gauge']);
$gauge = [
        'chart' =>[
            'type' => 'solidgauge',
            'backgroundColor' => 'transparent',
            'height' => 350
        ],

        'title' => null,

        'pane' => [
            'center'=> ['50%', '90%'],
            'size' =>  '140%',
            'startAngle' => -90,
            'endAngle' =>  90,
            'background' => [
                'innerRadius' => '60%',
                'outerRadius' => '100%',
                'shape' => 'arc'
            ]
        ],
        'yAxis' => [
            'min' => 0,
            'max' => 200,
            'title' => [
                'text' => 'Використаний обсяг'
            ],
            'stops' => [
                [0.1, '#DF5353'], // red
                [0.5, '#DDDF0D'], // yellow
                [0.9, '#55BF3B'], // green
            ],
            'lineWidth' => 0,
            'minorTickInterval' => null,
            'tickPixelInterval' => 100,
            'tickWidth' => 0,
            'title' => [
                'y' => -70
            ],
            'labels' => [
                'y' => 16
            ]
        ],

        'credits' => [
            'enabled' => false
        ],
        'tooltip' => [
            'enabled' => false
        ],
        'plotOptions' => [
            'solidgauge' => [
                'dataLabels' => [
                    'y' => 5,
                    'borderWidth' => 0,
                    'useHTML' => true
                ]
            ]
        ],
        'series' => [[
            'name' => 'Speed',
            'data' => [95],
            'dataLabels' => [
                'formatter' => new \yii\web\JsExpression("function(){ if (this.y==-1) { return '0%'}; return '<div style=\"text-align:center\"><span style=\"font-size:35px;color:"
                    ."((Highcharts.theme && Highcharts.theme.contrastTextColor) || \'black\')\">'+Math.round(this.y*100*100/this.series.yAxis.max)/100+'</span><br/>"
                    ."<span style=\"font-size:20px;color:silver\">%</span></div>';}")
            ],
            'tooltip' => [
                'valueSuffix' => ' %'
            ]
        ]]
];
?>
<h1><i class="fa fa-<?= $gtype->icon?>"></i> <?= Html::encode($gtype->name)?></h1>
<div class="type-head">
    <?php $ostat = $stat?>
    <?php krsort($stat);?>
    <?php while($portion = array_splice($stat, 0, 3)):?>
    <div class="row bg-success">
        <?php foreach($portion as $idx => $row):?>
        <div class="col-sm-4">
            <div class="" style="padding:0.5em">
                <h2>на фоні усих витрат</h2>

                <div class="text-center"><span class="badge" style="font-size:150%"><?= Yii::t('app', '{delta, plural, =1{1 pay} pays{# pays}}', ['delta' => $row['cnt']])?></span></div>
                <br/>
                <div class="text-center"><span class="label label-primary" style="font-size:250%"><?= Yii::$app->formatter->asCurrency($row['amount'])?></span></div>
            </div>
        </div>
        <div class="col-sm-8">
            <?php
            $inst = $gauge;
            $inst['yAxis']['max'] = round(app\models\Pays::find()->select(new \yii\db\Expression('sum(amount)'))->scalar());
            if ($inst['yAxis']['max'] > 0) {
                $inst['series'][0]['data'][0] = round($row['amount']);
            } else {
                $inst['series'][0]['data'][0] = -1;
            }
            echo Highcharts::widget(['options' => $inst]);?>
            </p>
        </div>
        <?php endforeach?>
    </div>
    <br/>
    <?php endwhile?>
</div>
<?= $this->render('@app/views/commons/_pays_list', [
    'prov' => $provPays
]);?>
