<?php

use yii\db\Migration;

/**
 * Class m240329_154056_report_book
 */
class m240329_154056_report_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'isbn' => $this->string(255),
            'cover_photo' => $this->string(255),
            'publish_year' => $this->smallInteger(),
            "description" => $this->text(),
            'is_new'  => $this->boolean()->defaultValue(true),
            'created_at' =>  $this->timestamp(),
            'updated_at' =>  $this->timestamp(),
        ]);

        //$this->createIndex('idx__book__name', 'book', 'name');

        $this->createTable('author', [
            'id' => $this->primaryKey(),
            //TODO lastname, firstname
            'name' => $this->string(255)->notNull(),
            'created_at' =>  $this->timestamp(),
            'updated_at' =>  $this->timestamp(),
        ]);

        $this->createTable("book_to_author", [
            "id" => $this->primaryKey(),
            'book_id' => $this->integer(),
            'author_id' => $this->integer(),
        ]);

        $this->addForeignKey('fk__book_to_author__book_id', 'book_to_author', 'book_id', 'book', 'id', "CASCADE");
        $this->addForeignKey('fk__book_to_author__author_id', 'book_to_author', 'author_id', 'author', 'id', "CASCADE");
        
        $this->createTable('subscriber_author', [
            'id' => $this->primaryKey(),
            'is_active'  => $this->boolean()->defaultValue(true),
            'author_id' => $this->integer()->notNull(),
            'phone' => $this->string(20)->notNull(),
            'created_at' =>  $this->timestamp(),
            'updated_at' =>  $this->timestamp(),
        ]);

        $this->createIndex('fk__subscriber_author__unique_author_id_phone', 'subscriber_author', ['author_id', 'phone']);
        $this->addForeignKey('fk__subscriber_author__author_id', 'subscriber_author', 'author_id', 'author', 'id');

        //test user
        $this->db->createCommand("
            INSERT INTO user (id, username, auth_key, password_hash, password_reset_token, email, status, created_at, updated_at, verification_token) VALUES (1, 'test', 'xyXxY0S0NkWPWspNwWmOjFKGGCQWKviF', '$2y$13$.XNQ2dXYzctUhgte6uXfOOmaF8uH4uJCCehlKR2lp7VrEbb1fi15y', null, 'mmm@yandex.ru', 10, 1711785437, 1711785437, 'IG2ZbM-obX7vvBQCEp-hWrDJsE_l2nWJ_1711785437');
        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('book_to_author');
        $this->dropTable('subscriber_author');
        $this->dropTable('author');
        $this->dropTable('book');
        $this->delete('user', ['username' => 'test']);
    }

}
