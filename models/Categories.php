<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Categories extends ActiveRecord
{
    public static function tableName()
    {
        return 'categories';
    }

    public function rules()
    {
        return [
            [['cat_name'], 'required'],
            [['cat_parent_id'], 'integer'],
            [['cat_name'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'cat_id' => 'ID',
            'cat_name' => 'Категория',
        ];
    }

    public function getPosts()
    {
        return $this->hasMany(Posts::className(), ['posts_cat_id' => 'cat_id'])->orderBy(['posts_time'  => SORT_DESC]);
    }

    public function  getCategories()
    {
        return $this->hasMany(Categories::className(), ['cat_parent_id'=>'cat_id'])->orderBy(['cat_name' => SORT_ASC]);
    }

    public function  getCategory()
    {
        return $this->hasOne(Categories::className(), ['cat_id'=>'cat_parent_id']);
    }

}