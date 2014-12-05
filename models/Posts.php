<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Posts extends ActiveRecord
{
    public static function tableName()
    {
        return 'posts';
    }

    public function rules()
    {
        return [
            [['posts_name', 'posts_text', 'posts_cat_id', 'posts_author'], 'required'],
            [['posts_cat_id'], 'integer'],
            [['posts_text'], 'string', 'max' => 500],
            [['posts_author', 'posts_name'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'posts_id' => 'ID',
            'posts_author' => 'Автор',
            'posts_text' => 'Текст поста',
            'posts_cat_id' => 'ID категории',
            'posts_name' => 'Заголовок поста',
        ];
    }

    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['com_posts_id' => 'posts_id'])->orderBy(['com_time' => SORT_DESC]);
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['cat_id' => 'posts_cat_id']);
    }
}