<?php

use yii\db\Schema;
use yii\db\Migration;

class m141205_082617_blog_table extends Migration
{
    public function up()
    {
        $this->createTable('posts',[
            'posts_id' => 'pk',
            'posts_name' => Schema::TYPE_STRING. 'NOT NULL',
            'posts_cat_id' => Schema::TYPE_BIGINT. 'NOT NULL',
            'posts_text' => Schema::TYPE_TEXT. 'NOT NULL',
            'posts_author' => Schema::TYPE_STRING. 'NOT NULL',
            'posts_time' => Schema::TYPE_TIMESTAMP. 'DEFAULT CURRENT_TIMESTAMP',

        ]);
    }

    public function down()
    {
        $this->dropTable('posts');
        $this->dropTable('comments');
        $this->dropTable('categories');
    }
}
