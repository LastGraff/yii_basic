<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Categories;
use app\models\Comments;
use app\models\Posts;
use yii\filters\AccessControl;
use yii\helpers\Url;


class CategoriesController extends Controller
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
        return $this->render('categories', ['catModels' => $catModels, 'postsModels' => $postsModels, 'breadCrumbs' => $breadCrumbs, 'catId' => $catId]);
    }

    private function edit ($model)
    {
        $breadCrumbs = ['label'=>'Blog', 'url'=>['/categories', 'catId'=>null]];
        $catTmp = Categories::findOne($model->cat_parent_id);
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

    public function actionUpdate ($catId = null)
    {
        $model = Categories::findOne($catId);
        if (!$model)
        {
            $model = new Categories();
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $this->redirect(Url::toRoute(['index','catId'=>$catId]));
        } else {
            return $this->edit($model);
        }

    }

    public function actionDelete ($catId = null)
    {
        $model = Categories::findOne($catId);
        if ($model)
            $model->delete();
        $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function actionCreate ($parentId = null)
    {
        $model = new Categories();
        $model->cat_parent_id = $parentId;
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $this->redirect(Url::toRoute(['index','catId'=>$parentId]));
        } else {
            return $this->edit($model);
        }
    }

}