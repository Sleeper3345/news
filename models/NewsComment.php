<?php

namespace app\models;

use app\models\query\NewsCommentQuery;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "news_comment".
 *
 * @property int $id
 * @property string $comment Текст комментария
 * @property int $news_id ID новости
 * @property int $user_id ID пользователя
 * @property int $created_at Дата создания
 * @property int $updated_at Дата обновления
 *
 * @property News $news
 * @property User $user
 */
class NewsComment extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%news_comment}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['comment', 'news_id', 'user_id'], 'required'],
            [['comment'], 'string'],
            [['news_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::class, 'targetAttribute' => ['news_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'Номер',
            'comment' => 'Текст комментария',
            'news_id' => 'Новость',
            'user_id' => 'Пользователь',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate(): bool
    {
        $this->user_id = Yii::$app->user->identity->id;

        return parent::beforeValidate();
    }

    /**
     * @return ActiveQuery
     */
    public function getNews(): ActiveQuery
    {
        return $this->hasOne(News::class, ['id' => 'news_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return NewsCommentQuery
     */
    public static function find(): NewsCommentQuery
    {
        return new NewsCommentQuery(get_called_class());
    }
}
