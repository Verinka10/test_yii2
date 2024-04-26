<?php

namespace common\behaviors;

use yii\db\ActiveRecord;
use yii\base\Behavior;
use yii\web\UploadedFile;
use Yii;
use yii\helpers\FileHelper;

/**
 * Class FileUploadBehavior
 * @package common\behaviors
 */
class FileUploadBehavior extends Behavior
{
    public $attributeName = 'file';
    public $model;
    //TODO
    //public $minSize;
    //public $maxSize;
    public $types = '';
    public $uploadPath = '';
    //public $resizeOnUpload;
    //public $resizeOptions = [];
    public $file;
    public $url = '@web';
    public $pref = '{id}_';


    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_UPDATE => 'updateAttribute',
            ActiveRecord::EVENT_BEFORE_INSERT => 'updateAttribute',
            ActiveRecord::EVENT_AFTER_INSERT =>  'updateAttributeAfterInsert'
        ];
    }


    public function updateAttribute()
    {
        if ($this->owner->isNewRecord && $this->getPref() != $this->pref) {
            return;
        }

        if ($this->owner->{$this->attributeName} instanceof UploadedFile) {
            $this->file = $this->owner->{$this->attributeName};
        } else {
            $this->file = UploadedFile::getInstance($this->owner, $this->attributeName);
        }

        if ($this->file instanceof UploadedFile) {
            $directory = dirname($this->getPathName($this->file->name));
            if (!is_dir($directory)) {
                FileHelper::createDirectory($directory);
            }
            if ($this->file->saveAs($this->getPathName($this->file->name))) {
                $this->owner->{$this->attributeName} = $this->file->name;
            }
        } else {
            $this->owner->{$this->attributeName} = $this->owner->getOldAttribute($this->attributeName);
        }
    }

 
    public function updateAttributeAfterInsert()
    {
        if ($this->getPref() != $this->pref) {
            $this->updateAttribute();
            $this->owner->updateAttributes([$this->attributeName => $this->owner->{$this->attributeName}]);
        }
    }

    /**
     * @param string $fileName
     * @return string
     */
    public function getPathName($fileName)
    {
        return Yii::getAlias($this->uploadPath . '/' . $this->getPref() . $fileName);
    }
    
    public function getFilePath()
    {
        if ($this->owner->{$this->attributeName}) {
            return $this->getPathName($this->owner->{$this->attributeName});
        }
    }
    
    public function getPref()
    {
        $pref = preg_replace_callback("/\{\w+\}/",function($matches){  
            return $this->owner->{trim($matches[0],'{}')};
        }, $this->pref);

        return $pref;
    }

    /**
     * @param string $fileName
     * @return string
     */
    public function getUrl()
    {
        if (!$this->owner->{$this->attributeName}) {
            return null;
        }
        return Yii::getAlias($this->url . '/' .  $this->getFilePath());
    }


    /**
     * @param string $pref
     * @param string $delim
     * @param number $len
     * @return string
     */
    protected function getRandomFileName($len = 6)
    {
        return $this->getPref() . Yii::$app->security->generateRandomString($len);
    }

    public function deleteUpload()
    {
        /*$iterator = new \GlobIterator($maskFilePath);
        foreach ($iterator as $file) {
            @unlink($file->getRealPath());
        }
        return true;*/
        if (!@unlink($this->getFilePath())) {
            return false;
        }
        $this->owner->updateAttributes([$this->attributeName => null]);
        return true;
    }
    

}
