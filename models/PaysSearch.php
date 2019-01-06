<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pays;


/**
 * This is the model class
 *
 * @property string $year
 */
class PaysSearch extends Model
{
    public $org_id;
    public $type_id;
    public $keyword;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['org_id', 'type_id'], 'integer'],
            [['keyword'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kyeword' => 'Ключове слово',
        ];
    }

    public function initDefaultValues()
    {
    }

    public function search($params)
    {
        $query = Pays::find();
        $prov = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 40
            ]
        ]);

        if (!empty($params)) {
            $this->load($params);

            if (strlen($this->keyword)) {
                $query->andWhere([
                    'or',
                    ['like', 'payment_details', $this->keyword],
                    ['like', 'recipt_name', $this->keyword],
                ]);
            }

        }

        if (is_numeric($this->type_id)) {
            $query->alias('t');
            $query->innerJoin(['tt' => 'ttypes'], [
                'and',
                't.id = tt.tranz_id',
                ['tt.type_id' => $this->type_id]
            ]);
        }

        if (is_numeric($this->org_id)) {
            $query->alias('t');
            $query->innerJoin(['tt' => 'torgs'], [
                'and',
                't.id = tt.tranz_id',
                ['tt.org_id' => $this->org_id]
            ]);
        }

        return $prov;
    }
}
