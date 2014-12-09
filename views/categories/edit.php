<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = $model->cat_id ? 'Редактирование: '.$model->cat_name : 'Создание категории';
$this->params['breadcrumbs'] = $breadCrumbs;
?>
<div class="cat-edit">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'edit-form', 'method' => 'post']); ?>
            <?= $form->field($model, 'cat_name') ?>
            <?= $form->field($model, 'cat_id')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'cat_parent_id')->hiddenInput()->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'edit-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
