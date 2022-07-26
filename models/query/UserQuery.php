<?php

namespace app\models\query;

use app\models\User;
use yii\db\ActiveQuery;
use yii\db\Connection;

/**
 * This is the ActiveQuery class for [[\app\models\User]].
 *
 * @see \app\models\User
 */
class UserQuery extends ActiveQuery
{
    /**
     * @param Connection|null $db
     * @return User[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param Connection|null $db
     * @return User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
