<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use app\models\Pays;
use app\models\PaysSearch;

class PaysController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new PaysSearch();
        if (Yii::$app->request->get('PaysSearch', false)===false) {
            $searchModel->initDefaultValues();
        }

        $prov = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'search'     => $searchModel,
            'prov'       => $prov
        ]);
        return $this->render('index');
    }

    public function actionLink($id)
    {
        $model = $this->findModel($id);

        return $this->render('detail', [
            'model' => $model
        ]);
    }

    public function actionAjaxDetail($id, $t=null)
    {
        $model = $this->findModel($id);
            
        return $this->renderAjax('ajax-detail', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Pays::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
