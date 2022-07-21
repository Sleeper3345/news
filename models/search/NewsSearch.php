<?php

namespace app\models\search;

use app\models\News;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class NewsSearch
 * @package app\models\search
 */
class NewsSearch extends Model
{
    /** @var int */
    public $category_id;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['category_id'], 'safe'],
            [['category_id'], 'integer'],
        ];
    }

    /**
     * @return string
     */
    public function formName(): string
    {
        return '';
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params = []): ActiveDataProvider
    {
        $sort = [];

        if (empty($params['sort'])) {
            $sort['updated_at'] = SORT_DESC;
        }

        $query = News::find()
            ->orderBy($sort);

        $config = [
            'query' => $query,
            'pagination' => [
                'pageSize' => 3,
            ],
        ];

        $dataProvider = new ActiveDataProvider($config);

        if (!$this->load($params) || !$this->validate()) {
            $query->andWhere([News::tableName() . '.id' => null]);
            return $dataProvider;
        }

        $query->active();

        if ($this->category_id) {
            $query->andWhere([News::tableName() . '.category_id' => $this->category_id]);
        }

        return new ActiveDataProvider($config);
    }
}
