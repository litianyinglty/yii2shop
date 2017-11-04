<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m171104_032452_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(60)->notNull()->defaultValue("")->comment('名称'),
            'author'=>$this->string(30)->notNull()->defaultValue("匿名")->comment("作者"),
            'intro'=>$this->string()->comment("简介"),
            'sort'=>$this->smallInteger()->defaultValue("10")->comment("排序"),
            'status'=>$this->smallInteger(1)->comment("状态"),
            'insert_time'=>$this->integer()->comment("插入时间"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
