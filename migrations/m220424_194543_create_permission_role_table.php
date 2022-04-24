<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%permission_role}}`.
 */
class m220424_194543_create_permission_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%permission_role}}', [
            'permission_id' => $this->integer(),
            'role_id' => $this->integer(),
            'PRIMARY KEY(permission_id, role_id)',
        ]);

        // creates index for column `permission_id`
        $this->createIndex(
            '{{%idx-permission_role-permission_id}}',
            '{{%permission_role}}',
            'permission_id'
        );

        // add foreign key for table `{{%permission}}`
        $this->addForeignKey(
            '{{%fk-permission_role-permission_id}}',
            '{{%permission_role}}',
            'permission_id',
            '{{%permission}}',
            'id',
            'CASCADE'
        );

        // creates index for column `role_id`
        $this->createIndex(
            '{{%idx-permission_role-role_id}}',
            '{{%permission_role}}',
            'role_id'
        );

        // add foreign key for table `{{%role}}`
        $this->addForeignKey(
            '{{%fk-permission_role-role_id}}',
            '{{%permission_role}}',
            'role_id',
            '{{%role}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%permission}}`
        $this->dropForeignKey(
            '{{%fk-permission_role-permission_id}}',
            '{{%permission_role}}'
        );

        // drops index for column `permission_id`
        $this->dropIndex(
            '{{%idx-permission_role-permission_id}}',
            '{{%permission_role}}'
        );

        // drops foreign key for table `{{%role}}`
        $this->dropForeignKey(
            '{{%fk-permission_role-role_id}}',
            '{{%permission_role}}'
        );

        // drops index for column `role_id`
        $this->dropIndex(
            '{{%idx-permission_role-role_id}}',
            '{{%permission_role}}'
        );

        $this->dropTable('{{%permission_role}}');
    }
}
