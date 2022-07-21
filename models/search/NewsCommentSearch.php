<?php

namespace app\models\search;

use app\models\NewsComment;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class NewsCommentSearch
 * @package app\models\search
 */
class NewsCommentSearch extends Model
{
    /** @var int */
    public $news_id;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['news_id'], 'required'],
            [['news_id'], 'integer'],
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

        $query = NewsComment::find();

        $config = [
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ];

        $dataProvider = new ActiveDataProvider($config);

        if (!$this->load($params) || !$this->validate()) {
            $query->andWhere([NewsComment::tableName() . '.id' => null]);
            return $dataProvider;
        }

        $query->innerJoinWith('user')
            ->orderBy($sort);

        $query->andWhere([NewsComment::tableName() . '.news_id' => $this->news_id]);

        return $dataProvider;
    }
}
