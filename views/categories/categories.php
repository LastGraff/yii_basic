<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
$this->params['breadcrumbs'] = $breadCrumbs;
$this->title = array_pop($breadCrumbs)['label'];
?>
<div class="row">
    <div class="col-md-3 blog-categories">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php
        $itemList =[];
        foreach ($catModels as $cat)
        {
            $itemList[] = ['label'=>$cat->cat_name, 'url'=>['/categories', 'catId'=>$cat->cat_id]];
        }?>

        <?php
        echo Nav::widget([
            'items' => $itemList,
        ]);
        ?>
    </div>
    <div class="col-md-9 blog-posts">
        <?php
        $itemList =[];
        foreach ($postsModels as $post)
        {
            $itemList[] = '<li class="dropdown-header">'.$post->posts_author.' '.$post->posts_time.'</li>';
            $itemList[] = ['label'=>$post->posts_name, 'url'=>['/posts', 'postId'=>$post->posts_id]];
            $itemList[] = '<li class="divider"></li>';
        }
        echo Nav::widget([
            'items' => $itemList,
        ]);
        ?>
    </div>
</div>
