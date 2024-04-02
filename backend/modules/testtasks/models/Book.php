<?php

namespace app\modules\testtasks\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use voskobovich\linker\LinkerBehavior;
use common\behaviors\FileUploadBehavior;
use common\components\jobs\SubscriberSend;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $name
 * @property string|null $isbn
 * @property int|null $publish_year
 * @property string|null $description
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property BookToAuthor[] $bookToAuthors
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['publish_year'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'isbn'], 'string', 'max' => 255],
            [['author_ids'], 'each', 'rule' => ['integer']],
            [['cover_photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'isbn' => 'Isbn',
            'publish_year' => 'Publish Year',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[BookToAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->viaTable('book_to_author', ['book_id' => 'id']);
    }

    /**
     * Gets query for [[BookToAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubscribers()
    {
        return $this->hasMany(SubscriberAuthor::class, ['author_id' => 'author_id'])->viaTable('book_to_author', ['book_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return BookQuery the active query used by this AR class.
     */
    public static function find()
    {

        return new BookQuery(get_called_class());
    }
    
    /**
     * {@inheritDoc}
     * @see \yii\base\Component::behaviors()
     */
    public function behaviors()
    {
        return [
            /*'create_update_from' => [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => 'updated_user_id',
                'createdByAttribute' => 'created_user_id'
            ],*/
            'timestampBehavior' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
            'ManyToManyBehavior' => [
                'class' => LinkerBehavior::class,
                'relations' => [
                    'author_ids' => 'authors',
                ],
            ],
            'coverUpload' => [
                'class' => FileUploadBehavior::class,
                'attributeName' => 'cover_photo',
                'types' => 'jpg,jpeg,png,gif',
                'uploadPath' => 'uploads/cover',
                'pref' => "cover_{id}_",
            ]
        ];
    }

    public function addQueueSubscribers()
    {
        // one by phone
        $query = $this->getSubscribers()->select('phone')->distinct();

        foreach ($query->each() as $subscriber) {
            /**@var SubscriberAuthor $subscriber */
            \Yii::$app->queue->push(new SubscriberSend([
                'message' => "New book for you!",
                'phone' => $subscriber->phone,
            ]));
        }
    }

}
