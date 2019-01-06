<?php

use yii\db\Migration;

class m190102_200658_make_orgs extends Migration
{
    public function safeUp()
    {
        $this->execute("
            create table g_orgs(
                id integer primary key,
                name text collate nocase,
                edrpou BIGINT null
            );
        ");

        $this->execute("
            create table torgs(
                org_id BIGINT, 
                tranz_id BIGINT, 
                UNIQUE (org_id, tranz_id),
                FOREIGN KEY (org_id) REFERENCES g_orgs (id),
                FOREIGN KEY (tranz_id) REFERENCES tranz (id)
            );
        ");

        $orgs = [];
        $orgs_edrpou = [];
        $orgs_fop    = [];
        $orgs_link = [];
        $rows = (new \yii\db\Query())
            ->select(['id', 'recipt_edrpou', 'recipt_name'])
            ->from('tranz')
            ->all();
        $org_cntr = 0;
        foreach($rows as $row) {
            $name_lower = mb_strtolower($row['recipt_name']);
            $name_short = $row['recipt_name'];
            switch($row['recipt_name']) {
                case 'Криворiзьке УК/Криворiз.р-н/11011000':
                case 'Криворiзьке УК/Криворiз.р-н/11011000':
                case 'Криворiзьке УК/Криворiз.р-н/41040400':
                case 'Криворiзьке УК/Криворiз.р-н/41053900':
                case 'УК у Криворiз.р/с.Новопiлля/11010100':
                case 'УК у Криворiз.р/с.Новопiлля/41040400':
                case 'УК у криворiз р/с.Новопiлля/18010500':
                case 'УКу Криворiз р/с.Новопiлля/18010500':
                    $name_lower = 'криворiзьке ук/криворiз.р-н';
                    $name_short = 'Криворiзьке УК/Криворiз.р-н';
                    break;

                case 'ТОВ "Навч-консалтинговий центр "Закупi':
                case 'ТОВ "Навчально-консалтинговий центр "З':
                    $name_lower = 'тов "навч-консалтинговий центр "закупi';
                    $nam_short = 'ТОВ "Навчально-консалтинговий центр "Закупівлі"';
                    break;

                case 'АТ "ДТЕК ДНiПРОВСЬКi ЕЛЕКТРОМЕРЕЖi"':
                case 'АТ "ДТЕК Днiпровськi електромережi"':
                case 'ПАТ "ДТЕК ДНiПРООБЛЕНЕРГО"':
                case 'ПАТ ДТЕК Днiпрообленерго Криворiзький':
                    $name_lower = 'дтек';
                    $name_short = 'АТ "ДТЕК Днiпровськi електромережi"';
                    break;

                case 'ПАТ " ЦЕК"':
                case 'ПАТ "ЦЕК"':
                    $name_lower = 'цек';
                    $name_short = 'ПАТ "ЦЕК"';
                    break;

                case 'ДП "Нацiональнi iнформацiйнi системи"';
                case 'ДП Нацiональнi iнформацiйнi системи"':
                    $name_lower = 'нацiональнi iнформацiйнi системи';
                    $name_short = 'ДП "Нацiональнi iнформацiйнi системи"';
                    break;

                case 'ЖКП"Новопiлля"';
                case 'КП ЖКП"Новопiлля"':
                    $name_lower = 'кп жкп"Новопiлля"';
                    $name_short = 'КП ЖКП "Новопiлля"';
                    break;

                case 'ФОП ПАнченко Г.М.':
                case 'ФОП Панченко Г.М.':
                    $name_lower = 'панченко';
                    $name_short = 'ФОП Панченко Г.М.';
                    break;

            }

            if (is_numeric($row['recipt_edrpou'])) {
                if (array_key_exists($row['recipt_edrpou'], $orgs_edrpou)) {
                    $orgs_link[$row['id']] = $orgs_edrpou[$row['recipt_edrpou']];
                } else {
                    $orgs_link[$row['id']] = ++$org_cntr;
                    $orgs_edrpou[$row['recipt_edrpou']] = $org_cntr;
                    $orgs[$org_cntr] = [
                        'name'   => $name_short,
                        'edrpou' => $row['recipt_edrpou']
                    ];
                }
            } else if (strpos($row['recipt_edrpou'], 'xx') !== false) {
                if (array_key_exists($name_lower, $orgs_fop)) {
                    $orgs_link[$row['id']] = $orgs_fop[$name_lower];
                } else {
                    $orgs_link[$row['id']] = ++$org_cntr;
                    $orgs_fop[$name_lower] = $org_cntr;
                    $orgs[$org_cntr] = [
                        'name'   => $name_short,
                        'edrpou' => null
                    ];
                }
            }
        }

        Yii::$app->db->createCommand()
            ->batchInsert('g_orgs', ['id', 'name', 'edrpou'], array_map(function($k, $v) {
                return [$k, $v['name'], $v['edrpou']];
            }, array_keys($orgs), $orgs))
            ->execute();

        Yii::$app->db->createCommand()
            ->batchInsert('torgs', ['tranz_id', 'org_id'], array_map(function($k, $v) {
                return [$k, $v];
            }, array_keys($orgs_link), $orgs_link))
            ->execute();

        //return false;


    }

    public function safeDown()
    {
        $this->dropTable('torgs');
        $this->dropTable('g_orgs');
    }
}
