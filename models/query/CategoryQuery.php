<?php

namespace app\models\query;

use app\models\Category;
use yii\db\ActiveQuery;
use yii\db\Connection;
use yii\helpers\ArrayHelper;

/**
 * This is the ActiveQuery class for [[\app\models\Category]].
 *
 * @see \app\models\Category
 */
class CategoryQuery extends ActiveQuery
{
    /**
     * @param Connection|null $db
     * @return Category[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param Connection|null $db
     * @return Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return array
     */
    public function collection(): array
    {
        $categories = $this
            ->select(['id', 'name'])
            ->all();

        return ArrayHelper::map($categories, 'id', 'name');
    }
}
