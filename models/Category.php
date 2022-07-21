<?php

namespace app\models;

use app\models\query\CategoryQuery;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\redis\Connection;

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
 * @property News $news
 */
class Category extends ActiveRecord
{
    /** @var bool */
    public $skip = false;

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
    public function attributeLabels(): array
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
     * @param bool $insert
     * @param array $changedAttributes
     * @throws InvalidConfigException
     */
    public function afterSave($insert, $changedAttributes): void
    {
        self::clearCache();
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @throws InvalidConfigException
     */
    public function afterDelete(): void
    {
        self::clearCache();
        parent::afterDelete();
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
     * @return ActiveQuery
     */
    public function getNews(): ActiveQuery
    {
        return $this->hasMany(News::class, ['category_id' => 'id']);
    }

    /**
     * @return CategoryQuery
     */
    public static function find(): CategoryQuery
    {
        return new CategoryQuery(get_called_class());
    }

    /**
     * @param array $categories
     * @return array
     * @throws InvalidConfigException
     */
    public static function getCategoriesForMenu(array $categories = []): array
    {
        /** @var Connection $cache */
        $cache = Yii::$app->get('redis');
        $cacheData = $cache->get('categories');

        if ($cacheData !== null) {
            return Json::decode($cacheData);
        }

        if (empty($categories)) {
            $categories = self::find()
                ->where(['parent_id' => null])
                ->all();

            $items = [];
        }

        foreach ($categories as $category) {
            $item = ['label' => $category->name, 'url' => Url::toRoute(['/site/index', 'categoryId' => $category->id])];
            $subCategories = $category->categories;

            if (!empty($subCategories)) {
                $item['items'] = self::getCategoriesForMenu($subCategories);
            }

            $items[] = $item;
        }

        Yii::$app->redis->set('categories', Json::encode($items));

        return $items;
    }

    /**
     * @throws InvalidConfigException
     */
    private static function clearCache(): void
    {
        /** @var Connection $cache */
        $cache = Yii::$app->get('redis');
        $cache->del('categories');
    }
}
