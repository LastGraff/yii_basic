<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->params['breadcrumbs'] = $breadCrumbs;
$this->title = array_pop($breadCrumbs)['label'];
?>
<div class="row">
    <div class="col-md-4 blog-categories">
        <h1><?= Html::encode($this->title) ?><a href="<?=Url::toRoute(['update','catId'=> $catId])?>"><span class="glyphicon glyphicon-pencil"></span></a>
                <a href="<?=Url::toRoute(['create','parentId'=> $catId])?>"><span class="glyphicon glyphicon-plus"></span></a>
                <a href="<?=Url::toRoute(['posts/create','catId'=> $catId])?>"><span class="glyphicon glyphicon-file"></span></a>
        </h1>
        <ul class="nav nav-tabs nav-stacked">
        <?php
        $itemList =[];
        foreach ($catModels as $cat)
        {
            $itemList[] = ['label'=>'<div>'.$cat->cat_name.'<a href="'.Url::toRoute(['delete','catId'=>$cat->cat_id]).'"><span class="glyphicon glyphicon-remove"></span></a></div>', 'url'=>['/categories', 'catId'=>$cat->cat_id]];
        }?>
        </ul>

        <?php
        echo Nav::widget([
            'encodeLabels' => false,
            'items' => $itemList,
        ]);
        ?>
    </div>
    <div class="col-md-8 blog-posts">
        <?php
        $itemList =[];
        foreach ($postsModels as $post)
        {
            $itemList[] = '<li class="dropdown-header"><div>'.$post->posts_author.' '.$post->posts_time.
                '<a href="'.Url::toRoute(['posts/delete','postId'=>$post->posts_id]).'"><span class="glyphicon glyphicon-remove"></span></a></div></li>';
            $itemList[] = ['label'=>$post->posts_name, 'url'=>['/posts', 'postId'=>$post->posts_id]];
            $itemList[] = '<li class="divider"></li>';
        }
        echo Nav::widget([
            'items' => $itemList,
        ]);
        ?>
    </div>

</div>
