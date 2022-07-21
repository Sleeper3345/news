<?php

namespace app\models\search;

use app\models\Category;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class CategorySearch
 * @package app\models\search
 */
class CategorySearch extends Model
{
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params = []): ActiveDataProvider
    {
        $sort = [];

        if (empty($params['sort'])) {
            $sort['id'] = SORT_DESC;
        }

        $query = Category::find()
            ->leftJoin(Category::tableName() . ' parent', Category::tableName() . '.parent_id = parent.id')
            ->orderBy($sort);

        $config = [
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ];

        return new ActiveDataProvider($config);
    }
}