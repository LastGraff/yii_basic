<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->params['breadcrumbs'] = $breadCrumbs;
$this->title = array_pop($breadCrumbs)['label'];
?>
<div class="blog-post">
    <h1><?= Html::encode($this->title) ?><a href="<?=Url::toRoute(['update','postId'=> $postId])?>"><span class="glyphicon glyphicon-pencil"></span></a>
        <a href="<?=Url::toRoute(['comments/create','postId'=> $postId])?>"><span class="glyphicon glyphicon-file"></span></a>
    </h1>
    <p><?= $post->posts_text ?></p>
</div>
<div class="blog-comments">
    <?php
    foreach ($comModels as $com)
    {
        echo '<div class="row">';
        echo '<div class="col-sm-'.$com[1].'"></div>';
        echo '<div class="col-md-6 comment"><small><em>'.$com[0]->com_author.' '.$com[0]->com_time.'</em></small>
                <a href="'.Url::toRoute(["comments/update","comId"=> $com[0]->com_id]).'"><span class="glyphicon glyphicon-pencil"></span></a>
                <a href="'.Url::toRoute(["comments/create","comId"=> $com[0]->com_id, "postId" => $postId]).'"><span class="glyphicon glyphicon-file"></span></a>
                <a href="'.Url::toRoute(["comments/delete","comId"=> $com[0]->com_id]).'"><span class="glyphicon glyphicon-remove"></span></a>
        <p>'.$com[0]->com_text.'</p></div>';
        echo '</div>';
    }
    ?>
</div>
