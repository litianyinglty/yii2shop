<?php

use yii\db\Migration;

/**
 * Handles the creation of table `articlecate`.
 */
class m171104_034636_create_articlecate_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('articlecate', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(40)->notNull()->defaultValue("")->comment('文章分类名称'),
            'intro'=>$this->string(100)->comment('分类简介'),
            'sort'=>$this->smallInteger()->notNull()->defaultValue("5")->comment('分类排序'),
            'create_time'=>$this->integer()->comment("创建时间"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('articlecate');
    }
}
