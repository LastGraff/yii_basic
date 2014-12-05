<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Comments extends ActiveRecord
{
	public static function tableName()
    {
        return 'comments';
    }

    public function rules()
    {
        return [
            [['com_author', 'com_text', 'com_posts_id'], 'required'],
            [['com_posts_id', 'com_com_id'], 'integer'],
            [['com_text'], 'string', 'max' => 500],
            [['com_author'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'com_id' => 'ID',
            'com_author' => 'Автор',
            'com_text' => 'Комментарий',
            'com_posts_id' => 'ID родительского поста',
            'com_com_id' => 'ID родительского комментария',
        ];
    }

    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['com_com_id' => 'com_id'])->orderBy(['com_time' => SORT_DESC]);
    }

    public function getPost()
    {
        return $this->hasOne(Posts::className(), ['posts_id' => 'com_posts_id']);
    }
}