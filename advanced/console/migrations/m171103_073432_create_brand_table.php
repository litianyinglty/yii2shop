<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m171103_073432_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(30)->notNull()->defaultValue("")->comment("名称"),
            'intro'=>$this->string()->comment("简介"),
            'logo'=>$this->string(100)->comment("图片"),
            'sort'=>$this->smallInteger()->comment("排序"),
            'status'=>$this->smallInteger()->comment("状态"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}
