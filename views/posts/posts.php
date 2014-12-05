<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
$this->params['breadcrumbs'] = $breadCrumbs;
$this->title = array_pop($breadCrumbs)['label'];
?>
<div class="blog-post">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= $post->posts_text ?></p>
</div>
<div class="blog-comments">
    <?php
    foreach ($comModels as $com)
    {
        echo '<div class="row">';
        echo '<div class="col-sm-'.$com[1].'"></div>';
        echo '<div class="col-md-6 comment"><small><em>'.$com[0]->com_author.' '.$com[0]->com_time.'</em></small>
        <p>'.$com[0]->com_text.'</p></div>';
        echo '</div>';
    }
    ?>
</div>
