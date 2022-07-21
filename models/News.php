<?php

namespace app\models;

use app\helpers\SlugHelper;
use app\models\query\NewsQuery;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $slug Заголовок для URL
 * @property string $title Заголовок
 * @property int $category_id ID категории
 * @property string $announcement Анонс
 * @property string $text Подробный текст
 * @property bool $active Активность
 * @property int $created_at Дата создания
 * @property int $updated_at Дата обновления
 *
 * @property Category $category
 * @property NewsComment[] $newsComments
 */
class News extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%news}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['slug', 'title', 'category_id', 'announcement', 'text'], 'required'],
            [['category_id', 'created_at', 'updated_at'], 'integer'],
            [['active'], 'boolean'],
            [['active'], 'default', 'value' => true],
            [['text'], 'string'],
            [['slug', 'announcement'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 200],
            [['slug'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'Номер',
            'slug' => 'Заголовок для URL',
            'title' => 'Заголовок',
            'category_id' => 'Категория',
            'announcement' => 'Анонс',
            'text' => 'Подробный текст',
            'active' => 'Активность',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate(): bool
    {
        $this->slug = SlugHelper::generateString($this->title);

        return parent::beforeValidate();
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNewsComments(): ActiveQuery
    {
        return $this->hasMany(NewsComment::class, ['news_id' => 'id']);
    }

    /**
     * @return NewsQuery
     */
    public static function find(): NewsQuery
    {
        return new NewsQuery(get_called_class());
    }

    /**
     * @param int $id
     * @return self|null
     */
    public static function findById(int $id): ?self
    {
        return self::find()
            ->where(['id' => $id])
            ->one();
    }
}
