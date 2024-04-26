<?php

namespace app\modules\photobank\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\photobank\models\Photobank;

/**
 * PhotobankSearch represents the model behind the search form of `app\models\Photobank`.
 */
class PhotobankSearch extends Photobank
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'updated_at', 'created_at', 'updated_user_id', 'created_user_id'], 'integer'],
            [['filename', 'filename_origin', 'content_type', 'desription'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Photobank::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'updated_user_id' => $this->updated_user_id,
            'created_user_id' => $this->created_user_id,
        ]);

        $query->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'filename_origin', $this->filename_origin])
            ->andFilterWhere(['like', 'content_type', $this->content_type])
            ->andFilterWhere(['like', 'desription', $this->desription]);

        return $dataProvider;
    }
}
