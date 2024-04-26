<?php

namespace app\modules\photobank\models;

use Yii;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\UploadedFile;
use dosamigos\transliterator\TransliteratorHelper;
use yii\helpers\FileHelper;
use yii\imagine\Image;

/**
 * This is the model class for table "photobank".
 *
 * @property int $id
 * @property string|null $filename
 * @property string|null $filename_origin
 * @property string|null $content_type
 * @property string|null $desription
 * @property int|null $updated_at
 * @property int|null $created_at
 * @property int|null $updated_user_id
 * @property int|null $created_user_id
 *
 * @property User $createdUser
 * @property User $updatedUser
 */
class Photobank extends \yii\db\ActiveRecord
{
    public $file; 

    protected $path = '@webroot/upload/photobank';

    protected $url = '@web/upload/photobank';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photobank';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['updated_at', 'created_at', 'updated_user_id', 'created_user_id'], 'integer'],
            [['filename', 'filename_origin', 'desription'], 'string', 'max' => 255],
            [['content_type'], 'string', 'max' => 20],
            [['created_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_user_id' => 'id']],
            [['updated_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_user_id' => 'id']],
            //[['file'], 'file', 'skipOnEmpty' => true, 'extensions' => Yii::$app->params['typeImage']],
            [['file'], 'file', 'extensions' => Yii::$app->params['typeImage']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'filename_origin' => 'Filename Origin',
            'content_type' => 'Content Type',
            'desription' => 'Desription',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'updated_user_id' => 'Updated User ID',
            'created_user_id' => 'Created User ID',
        ];
    }

    /**
     * Gets query for [[CreatedUser]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getCreatedUser()
    {
        return $this->hasOne(User::class, ['id' => 'created_user_id']);
    }

    /**
     * Gets query for [[UpdatedUser]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUpdatedUser()
    {
        return $this->hasOne(User::class, ['id' => 'updated_user_id']);
    }

    /**
     * {@inheritdoc}
     * @return PhotobankQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PhotobankQuery(get_called_class());
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
            /*'fileUpload' => [
                'class' => FileUploadBehavior::class,
                'attributeName' => 'file',
                'types' => 'jpg,jpeg,png,gif',
                'uploadPath' => \Yii::$app->basePath . '/web/uploads/photobank',
                'pref' => "",
            ],*/
        ];
    }
    
    public function beforeSave($insert) {
        
        // for one file, manualy 
        if (!$this->file instanceof UploadedFile) {
            $this->file = UploadedFile::getInstance($this, $this->file);
        }
        if ($this->file instanceof UploadedFile) {
            $directory = $this->getDirectoryUpload();
            if (!is_dir($directory)) {
                FileHelper::createDirectory($directory);
            }
            $this->filename = strtolower(TransliteratorHelper::process($this->file->name));
            for($i=1; file_exists($directory . '/' . $this->filename); ++$i) {
                //$filename = preg_replace("/(\.\w+)$/", "_$i$1", $this->filename);
                // repalce _1 _2 _3
                $this->filename = preg_replace("/(_\d+)?(\.\w+)$/", "_$i$2", $this->filename); 
                //$this->filename = 
                //dump($this->filename);
                if ($i>10) break;
            }
            //dd($this->filename);
            $this->filename_origin = $this->file->name;
            $this->content_type = $this->file->type;
            if (!$this->file->saveAs($directory . '/' . $this->filename)) {
                $this->addError('file', 'error save');
                return false;
            }
        }
        return parent::beforeSave($insert);
    }
    
    public function getDirectoryUpload() {
        //return \Yii::$app->basePath . '/' . $this->path;
        return Yii::getAlias($this->path);
    }

    /**
     * @return boolean|string
     */
    public function getPathFileName() {
        if (!$this->filename) {
            return false;
        }
        return $this->getDirectoryUpload() . '/' . $this->filename;
    }

    /**
     * @param string $fileName
     * @return string|null
     */
    public function getUrl()
    {
        if (!file_exists($this->getPathFileName())) {
            return null;
        }
        return Yii::getAlias($this->url . '/' .  $this->filename);
    }
    
    /**
     * @param string $fileName
     * @return string|null
     */
    public function getThumbUrl()
    {
        if (!file_exists($this->getPathFileName())) {
            return null;
        }
        $directory = $this->getDirectoryUpload() . '/thumbs';
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }
        $fileName = $directory . '/' . $this->filename;
        if (!file_exists($fileName)) {
            Image::thumbnail($this->getPathFileName(), 100, 100)
                ->save($fileName);
        }

        return $this->url . '/thumbs/' . $this->filename;
    }
}
