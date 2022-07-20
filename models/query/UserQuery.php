<?php

namespace app\models\query;

use app\models\User;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\User]].
 *
 * @see \app\models\User
 */
class UserQuery extends ActiveQuery
{
    /**
     * @return User[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @return User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
