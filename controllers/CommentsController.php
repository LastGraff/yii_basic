<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Categories;
use app\models\Comments;
use app\models\Posts;
use yii\filters\AccessControl;
use yii\helpers\Url;

class CommentsController extends Controller
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

    private function edit ($model)
    {
        $breadCrumbs = ['label'=>'Blog', 'url'=>['/categories', 'catId'=>null]];
        $postTmp = Posts::findOne($model->com_posts_id);
        $catTmp = Categories::findOne($postTmp->posts_cat_id);
        $breadTmp =[['label'=> $catTmp->cat_name, 'url'=>['/categories','catId'=>$catTmp->cat_id]]];
        $breadTmp[] = ['label'=> $postTmp->posts_name, 'url'=>['/posts','postId'=>$postTmp->posts_id]];
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

    public function actionUpdate ($comId = null)
    {
        $model = Comments::findOne($comId);
        if (!$model)
        {
            $model = new Comments();
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $this->redirect(Url::toRoute(['posts/index','postId'=>$model->com_posts_id]));
        } else {
            return $this->edit($model);
        }

    }

    public function actionDelete ($comId = null)
    {
        $model = Comments::findOne($comId);
        if ($model)
            $model->delete();
        $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function actionCreate ($postId = null, $comId = null)
    {
        $model = new Comments();
        $model->com_posts_id = $postId;
        $model->com_com_id = $comId;
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $this->redirect(Url::toRoute(['posts/index','postId'=>$postId]));
        } else {
            return $this->edit($model);
        }
    }

}