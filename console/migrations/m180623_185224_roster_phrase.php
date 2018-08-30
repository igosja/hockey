<?php

use yii\db\Migration;

/**
 * Class m180623_185224_roster_phrase
 */
class m180623_185224_roster_phrase extends Migration
{
    const TABLE = '{{%roster_phrase}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'roster_phrase_id' => $this->primaryKey(1),
            'roster_phrase_text' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['roster_phrase_text'], [
            ['Уезжая надолго и без интернета - не забудьте поставить статус <a href="/user_holiday.php">в отпуске</a>'],
            ['<a href="/user_referral.php">Пригласите друзей</a> в Лигу и получите вознаграждение'],
            ['Если у вас есть вопросы - задайте их специалистам <a href="/support.php">тех.поддержки</a> Лиги'],
            ['Можно достичь высоких результатов, не нарушая правил'],
            ['Играйте честно - так интереснее выигрывать'],
        ]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
