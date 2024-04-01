<?php

namespace app\modules\testtasks\models;


class AuthorReport extends Author
{
    public $publish_year;
    public $count_book;

    /**
     * @return \app\modules\testtasks\models\AuthorQuery
     */
    static function findMostByYear()
    {
        return self::find()->innerJoinWith('books')
            ->select(['author.name', 'book.publish_year', 'count(*) count_book'])
            ->groupBy('author.name, book.publish_year')
        ->orderBy('count_book DESC, author.name');
    }
}
