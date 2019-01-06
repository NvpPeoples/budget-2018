<?php
use yii\helpers\Html;
use app\models\Orgs;
?>

<blockquote>
<big><?= Html::a($model['name'], ['/orgs/detail', 'id' => $model['id']])?></big>
<?php $school = Orgs::findOne($model['id']);?>
<div>
    <span class="pull-left"><?= $school->boss?></span>
    <span class="pull-right"><?= $school->phone?></span>
</div>
<div class="clearfix"></div>
</blockquote>
