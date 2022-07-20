<?php

namespace app\models;

use app\models\query\CategoryQuery;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name Название
 * @property int|null $parent_id ID родительской категории
 * @property int $created_at Дата создания
 * @property int $updated_at Дата обновления
 *
 * @property Category[] $categories
 * @property Category $parent
 */
class Category extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%category}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['parent_id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => self::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): string
    {
        return [
            'id' => 'Номер',
            'name' => 'Название',
            'parent_id' => 'Родительская категория',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getParent(): ActiveQuery
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    /**
     * @return CategoryQuery
     */
    public static function find(): CategoryQuery
    {
        return new CategoryQuery(get_called_class());
    }
}
