<?php

namespace app\modules\photobank\models;

/**
 * This is the ActiveQuery class for [[Photobank]].
 *
 * @see Photobank
 */
class PhotobankQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Photobank[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Photobank|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
