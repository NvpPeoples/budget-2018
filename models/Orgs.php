<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "Orgs".
 *
 * @property integer $id
 * @property string $name
 * @property integer $edrpou
 */
class Orgs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'g_orgs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['edrpou'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'     => 'ID',
            'name'   => 'Назва організації',
            'edrpou' => 'ЄДРПОУ',
        ];
    }

    public function getCntOfPays()
    {
        return (new Query())
            ->select(new Expression('count(*)'))
            ->from(['a' => Pays::tableName(), 'b' => 'torgs'])
            ->where([
                'and',
                'a.id = b.tranz_id',
                ['b.org_id' => $this->id]
            ])
            ->scalar();
    }

    public function getSummOfPays()
    {
        return (new Query())
            ->select(new Expression('round(sum(amount), 2)'))
            ->from(['a' => Pays::tableName(), 'b' => 'torgs'])
            ->where([
                'and',
                'a.id = b.tranz_id',
                ['b.org_id' => $this->id]
            ])
            ->scalar();
    }

}
