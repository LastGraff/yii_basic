<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Categories;
use app\models\Comments;
use app\models\Posts;

class PostsController extends Controller
{
    public function actionIndex ($postId = null)
    {
        function commentsTree ($input , $id = null, $level = 1)
        {
            $result = [];
            $tmp = array_filter($input, function ($var) use ($id){
                return ($var->com_com_id == $id);
            });
            $nextInput = array_filter($input, function ($var) use ($id){
                return ($var->com_com_id != $id);
            });
            foreach ($tmp as $item)
            {
                $result[] = [$item, $level];
                $result = array_merge($result, commentsTree($nextInput, $item->com_id, $level + 1));
            }
            return ($result);
        }
        $postsCurrent = Posts::findOne($postId);
        $cat = $postsCurrent->category;
        $comModels = commentsTree(Comments::findAll(['com_posts_id' => $postId]));
        $breadCrumbs = [['label'=>'Blog']];
        if ($postId)
        {
            $breadCrumbs = array_merge( $breadCrumbs[0],['url'=>['/categories', 'catId'=>null]]);
            $breadTmp = [['label'=>$postsCurrent->posts_name]];
            while ($cat)
            {
                $breadTmp = array_merge([['label'=> $cat->cat_name, 'url'=>['/categories','catId'=>$cat->cat_id]]], $breadTmp);
                $cat = $cat->category;
            }
            $breadCrumbs = array_merge([$breadCrumbs], $breadTmp);
        }
        return $this->render('posts', ['post' => $postsCurrent, 'comModels' => $comModels, 'breadCrumbs' => $breadCrumbs]);
    }
}