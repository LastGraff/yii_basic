<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Categories;
use app\models\Comments;
use app\models\Posts;
use yii\filters\AccessControl;
use yii\helpers\Url;

class PostsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

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
        return $this->render('posts', ['post' => $postsCurrent, 'comModels' => $comModels, 'breadCrumbs' => $breadCrumbs, 'postId' => $postId]);
    }

    private function edit ($model)
    {
        $breadCrumbs = ['label'=>'Blog', 'url'=>['/categories', 'catId'=>null]];
        $catTmp = Categories::findOne($model->posts_cat_id);
        $breadTmp = $catTmp ? [['label'=> $catTmp->cat_name, 'url'=>['/categories','catId'=>$catTmp->cat_id]]] : null;
        while ($catTmp && $catTmp = Categories::findOne($catTmp->cat_parent_id))
        {
            $breadTmp = array_merge([['label'=> $catTmp->cat_name, 'url'=>['/categories','catId'=>$catTmp->cat_id]]], $breadTmp);
        }
        $breadCrumbs = $breadTmp ? array_merge([$breadCrumbs], $breadTmp) : [$breadCrumbs];
        return $this->render('edit', [
            'model' => $model,
            'breadCrumbs' => $breadCrumbs,
        ]);
    }

    public function actionUpdate ($postId = null)
    {
        $model = Posts::findOne($postId);
        if (!$model)
        {
            $model = new Posts();
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $this->redirect(Url::toRoute(['index','postId'=>$model->posts_id]));
        } else {
            return $this->edit($model);
        }

    }

    public function actionDelete ($postId = null)
    {
        $model = Posts::findOne($postId);
        if ($model)
            $model->delete();
        $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function actionCreate ($catId = null)
    {
        $model = new Posts();
        $model->posts_cat_id = $catId;
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $this->redirect(Url::toRoute(['index','postId'=>$model->posts_id]));
        } else {
            return $this->edit($model);
        }
    }

}