<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%permission}}`.
 */
class m220424_204612_add_title_column_to_permission_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%permission}}', 'title', $this->string(100));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%permission}}', 'title');
    }
}
