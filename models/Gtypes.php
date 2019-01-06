<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "Gtypes".
 *
 * @property integer $id
 * @property string $name
 * @property string $icon
 */
class Gtypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'g_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'icon'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'   => 'ID',
            'name' => 'Напрямок витрат',
            'icon' => 'icon'
        ];
    }

    public function getCntOfPays()
    {
        return (new Query())
            ->select(new Expression('count(*)'))
            ->from(['a' => Pays::tableName(), 'b' => 'ttypes'])
            ->where([
                'and',
                'a.id = b.tranz_id',
                ['b.type_id' => $this->id]
            ])
            ->scalar();
    }

    public function getSummOfPays()
    {
        return (new Query())
            ->select(new Expression('round(sum(amount), 2)'))
            ->from(['a' => Pays::tableName(), 'b' => 'ttypes'])
            ->where([
                'and',
                'a.id = b.tranz_id',
                ['b.type_id' => $this->id]
            ])
            ->scalar();
    }

}
