<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = $model->com_id ? 'Редактирование комментария: ' : 'Создание комментария';
$this->params['breadcrumbs'] = $breadCrumbs;
?>
<div class="comment-edit">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'edit-form', 'method' => 'post']); ?>
            <?= $form->field($model, 'com_author') ?>
            <?= $form->field($model, 'com_text')->textArea(['rows' => 8]) ?>
            <?= $form->field($model, 'com_id')->hiddenInput() ?>
            <?= $form->field($model, 'com_posts_id')->hiddenInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'edit-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
