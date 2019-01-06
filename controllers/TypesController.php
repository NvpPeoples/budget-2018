<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\models\Gtypes;
use app\models\Pays;
use app\models\GtypeSearch;
use app\models\PaysSearch;

class TypesController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new GTypeSearch();
        if (Yii::$app->request->get('GTypeSearch', false)===false) {
            $searchModel->initDefaultValues();
        }
        $prov = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'search' => $searchModel,
            'prov'   => $prov
        ]);
    }

    public function actionDetail($id)
    {
        $gtype = $this->findModel($id);

        $id = $gtype->id;
        $stat = Yii::$app->getDb()->cache(function($db) use($id){
            return (new \yii\db\Query())
                ->select([
                    new \yii\db\Expression('count(*) as cnt'),
                    new \yii\db\Expression('round(sum(amount), 2) as amount')
                ])
                ->from(['a' => Pays::tableName(), 'b' => 'ttypes'])
                ->where([
                    'and',
                    'a.id = b.tranz_id',
                    ['b.type_id' => $id]
                ])
                ->all();
        }, 600);

        $searchModel = new PaysSearch();
        $searchModel->type_id = $id;

        $provPays = $searchModel->search([]);

        return $this->render('detail', [
            'gtype'    => $gtype,
            'stat'     => $stat,
            'provPays' => $provPays
        ]);
    }

    public function actionPays($ow)
    {
        $gtype = $this->findModel($ow);

        $searchModel = new PaysOnSchoolSearch();
        if (Yii::$app->request->get('PaysOnSchoolSearch', false)===false) {
            $searchModel->initDefaultValues();
        }
        $prov = $searchModel->search($gtype->id, Yii::$app->request->queryParams);
        $years_list = Yii::$app->getDb()->cache(function($db){
            return ArrayHelper::map(
                Pays::find()
                    ->distinct()
                    ->select(['yy as id', new \yii\db\Expression('yy||" рік" as title')])
                    ->orderBy('id desc')
                    ->asArray()
                    ->all(),
                'id', 'title');
        }, 600);

        return $this->render('pays', [
            'school'     => $gtype,
            'search'     => $searchModel,
            'years_list' => $years_list,
            'prov'       => $prov
        ]);
    }

    protected function findModel($id)
    {
        if (($model = GTypes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
