<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Categories;
use app\models\Comments;
use app\models\Posts;

class CategoriesController extends Controller
{
    public function actionIndex ($catId = null)
    {
        $catModels = Categories::findAll(['cat_parent_id' => $catId]);
        $postsModels = Posts::findAll(['posts_cat_id' => $catId]);
        $breadCrumbs = [['label'=>'Blog']];
        if ($catId)
        {
            $breadCrumbs = array_merge( $breadCrumbs[0],['url'=>['/categories', 'catId'=>null]]);
            $catTmp = Categories::findOne($catId);
            $breadTmp = [['label'=> $catTmp->cat_name]];
            while ($catTmp = Categories::findOne($catTmp->cat_parent_id))
            {
                $breadTmp = array_merge([['label'=> $catTmp->cat_name, 'url'=>['/categories','catId'=>$catTmp->cat_id]]], $breadTmp);
            }
            $breadCrumbs = array_merge([$breadCrumbs], $breadTmp);
        }
        return $this->render('categories', ['catModels' => $catModels, 'postsModels' => $postsModels, 'breadCrumbs' => $breadCrumbs]);
    }
}