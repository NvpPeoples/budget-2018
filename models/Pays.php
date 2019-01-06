<?php
namespace app\models;

use Yii;
use app\models\Orgs;

/**
 * This is the model class for table "Pays".
 *
 * @property integer $id
 * @property integer $id_school
 * @property integer $id_kindg
 * @property integer $yy
 * @property integer $qq
 * @property string $who
 * @property string $desc
 * @property double $summ
 */
class Pays extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tranz';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'doc_vob', 'doc_number', 'amount_cop'], 'integer'],
            [['doc_vob_name', 'desc', 'doc_date', 'doc_v_date', 'trans_date', 'currency',
                'payer_edrpou', 'payer_name', 'payer_account', 'payer_mfo', 'payer_bank',
                'recipt_edrpou', 'recipt_name', 'recipt_account', 'recipt_bank', 'recipt_mfo',
                'payment_details', 'doc_add_attr', 'region_id', 'payment_type', 'payment_data', 'source_id', 'source_name'], 'string'],
            [['amount'], 'number'],
        ];
    }

    public function getOrg()
    {
        return $this
            ->hasOne(Orgs::className(), ['id' => 'org_id'])
            ->viaTable('torgs', ['tranz_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'amount'          => 'Сума',
            'trans_date'      => 'Дата оплати',
            'payment_details' => 'Призначення платежу',
        ];
    }
}
