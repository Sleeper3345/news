<?php

namespace app\models\query;

use app\models\NewsComment;
use yii\db\ActiveQuery;
use yii\db\Connection;

/**
 * This is the ActiveQuery class for [[\app\models\NewsComment]].
 *
 * @see \app\models\NewsComment
 */
class NewsCommentQuery extends ActiveQuery
{
    /**
     * @param Connection|null $db
     * @return NewsComment[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param Connection|null $db
     * @return NewsComment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
