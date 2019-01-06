<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orgs;
use yii\db\Expression;


/**
 * This is the model class for table "Orgs".
 *
 * @property integer $id
 * @property string $name
 * @property string $boss
 * @property integer $code_reg
 * @property string $phone
 */
class OrgSearch extends Model
{
    public $keyword;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
        $this->keyword = '';
    }

    public function search($params)
    {
        $query = Orgs::find();
        $prov = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 40
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC
                ],
                'attributes' => [
                    'name',
                    'groupSumm' => [
                        'asc'  => [new Expression('random()')],
                        'desc' => [new Expression('random()')]
                    ],
                    'groupCnt' => [
                        'asc'  => [new Expression('random()')],
                        'desc' => [new Expression('random()')]
                    ]
                ]
            ]
        ]);

        if (strpos($params['sort'],'groupSumm') !== false) {
            $query->alias('t');
            $query->leftJoin(['tt' => 'torgs'], 'tt.org_id = t.id');
            $query->leftJoin(['pa' => 'tranz'], 'pa.id = tt.tranz_id');
            $query->select(['t.id', 't.name', new Expression('sum(pa.amount) as summ')]);
            $query->groupBy(['t.id', 't.name']);
            $prov->sort->attributes['groupSumm'] = [
                'asc'  => [new Expression('summ asc')],
                'desc' => [new Expression('summ desc')]
            ];

        } else if (strpos($params['sort'],'groupCnt') !== false) {
            $query->alias('t');
            $query->leftJoin(['tt' => 'torgs'], 'tt.org_id = t.id');
            $query->leftJoin(['pa' => 'tranz'], 'pa.id = tt.tranz_id');
            $query->select(['t.id', 't.name', new Expression('count(pa.amount) as cnt')]);
            $query->groupBy(['t.id', 't.name']);
            $prov->sort->attributes['groupCnt'] = [
                'asc'  => [new Expression('cnt asc')],
                'desc' => [new Expression('cnt desc')]
            ];
        }

        if (!empty($params)) {
            $this->load($params);

            if (strlen($this->keyword)) {
                $query->andWhere([
                    'or',
                    ['like', new Expression('lower(`name`)'), strtolower($this->keyword)],
                ]);
            }
        }

        return $prov;
    }
}
