<?php

use yii\db\Migration;

/**
 * Class m240425_124019_photobank
 */
class m240425_124019_photobank extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("photobank", [
            "id" => $this->primaryKey(),
            "filename" => $this->string(255),
            "filename_origin" => $this->string(255),
            "content_type" => $this->string(20),
            "desription" => $this->string(255),
            'created_at' =>  $this->timestamp(),
            'updated_at' =>  $this->timestamp(),
            'updated_user_id' => $this->integer(),
            'created_user_id' => $this->integer(),
        ]);
        
        /*$this->addForeignKey(
            'fk_photobank_updated_user_id',
            'photobank',
            'updated_user_id',
            'user',
            'id',
            "SET NULL",
            "SET NULL"
        );

        $this->addForeignKey(
            'fk_photobank_created_user_id',
            'photobank',
            'created_user_id',
            'user',
            'id',
            "SET NULL",
            "SET NULL"
        );*/

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        $this->dropTable("photobank");
    }
}
