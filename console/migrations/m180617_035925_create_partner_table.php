<?php

use yii\db\Migration;

/**
 * Handles the creation of table `partner`.
 * Has foreign keys to the tables:
 *
 * - `image`
 */
class m180617_035925_create_partner_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('partner', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'logo_image_id' => $this->integer()->notNull(),
            'website' => $this->string(),
            'sort_order' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `logo_image_id`
        $this->createIndex(
            'idx-partner-logo_image_id',
            'partner',
            'logo_image_id'
        );

        // add foreign key for table `image`
        $this->addForeignKey(
            'fk-partner-logo_image_id',
            'partner',
            'logo_image_id',
            'image',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `image`
        $this->dropForeignKey(
            'fk-partner-logo_image_id',
            'partner'
        );

        // drops index for column `logo_image_id`
        $this->dropIndex(
            'idx-partner-logo_image_id',
            'partner'
        );

        $this->dropTable('partner');
    }
}
