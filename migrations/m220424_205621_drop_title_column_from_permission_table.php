<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%permission}}`.
 */
class m220424_205621_drop_title_column_from_permission_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%permission}}', 'role_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%permission}}', 'role_id', $this->integer());
    }
}
