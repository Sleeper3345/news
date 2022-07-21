<?php

namespace app\models\query;

use app\models\News;
use yii\db\ActiveQuery;
use yii\db\Connection;

/**
 * This is the ActiveQuery class for [[\app\models\News]].
 *
 * @see \app\models\News
 */
class NewsQuery extends ActiveQuery
{
    /**
     * @return self
     */
    public function active(): self
    {
        return $this->andWhere([News::tableName() . '.active' => true]);
    }

    /**
     * @param string $slug
     * @return self
     */
    public function bySlug(string $slug): self
    {
        return $this->andWhere([News::tableName() . '.slug' => $slug]);
    }

    /**
     * @param Connection|null $db
     * @return News[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param Connection|null $db
     * @return News|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
