<?php

namespace app\models;

use app\helpers\UserRoleHelper;
use app\models\query\UserQuery;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username Имя пользователя
 * @property string|null $auth_key Токен
 * @property string $password_hash Пароль в hash
 * @property int $created_at Дата создания
 * @property int $updated_at Дата обновления
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['username', 'password_hash'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'Номер',
            'username' => 'Имя пользователя',
            'auth_key' => 'Токен',
            'password_hash' => 'Пароль',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * @return bool
     */
    public function isSuperadmin(): bool
    {
        return Yii::$app->authManager->getAssignment(UserRoleHelper::ROLE_SUPERADMIN, $this->id) !== null;
    }

    /**
     * @return UserQuery
     */
    public static function find(): UserQuery
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @param int $id
     * @return self|null
     */
    public static function findIdentity($id): ?self
    {
        return self::find()
            ->where(['id' => $id])
            ->one();
    }

    /**
     * @param string $token
     * @param mixed $type
     * @return self|null
     */
    public static function findIdentityByAccessToken($token, $type = null): ?self
    {
        return self::find()
            ->where(['auth_key' => $token])
            ->one();
    }

    /**
     * @param string $username
     * @return self|null
     */
    public static function findByUsername($username): ?self
    {
        return self::find()
            ->where(['username' => $username])
            ->one();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    /**
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
