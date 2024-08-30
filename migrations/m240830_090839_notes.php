<?php

use yii\db\Migration;

/**
 * Class m240830_090839_notes
 */
class m240830_090839_notes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand('
            CREATE TABLE IF NOT EXISTS `notes` (
                `id` int NOT NULL AUTO_INCREMENT,
                `title` varchar(50) DEFAULT NULL,
                `text` text,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

            INSERT INTO `notes` (`id`, `title`, `text`) VALUES
                (1, \'note1\', \'fsdfsd fsdfsdfsdf\'),
                (2, \'note2\', \'fsd fsdfsdfsdg dfgdfgdfg\'),
                (3, \'note3\', \'fsdf sdfasd  fasdfsd fasd fsd f\');

            CREATE TABLE IF NOT EXISTS `notes_tags` (
                `note_id` int DEFAULT NULL,
                `tag_id` int DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

            INSERT INTO `notes_tags` (`note_id`, `tag_id`) VALUES
                (1, 1),
                (1, 2),
                (1, 3),
                (2, 1),
                (3, 3);

            CREATE TABLE IF NOT EXISTS `tags` (
                `id` int NOT NULL AUTO_INCREMENT,
                `name` varchar(50) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `name` (`name`)
            ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

            INSERT INTO `tags` (`id`, `name`) VALUES
                (1, \'tag1\'),
                (2, \'tag2\'),
                (3, \'tag3\');
        ')->query();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand('
            drop table if exists notes;
            drop table if exists notes_tags;
            drop table if exists tags;
        ')->query();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240830_090839_notes cannot be reverted.\n";

        return false;
    }
    */
}
