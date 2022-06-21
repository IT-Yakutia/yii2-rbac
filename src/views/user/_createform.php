<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model ityakutia\rbac\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="new-user-form">

    <?php $form = ActiveForm::begin([
        'errorCssClass' => 'red-text',
    ]); ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $model->hasAttribute('phone') ? $form->field($model, 'phone')->textInput() : null ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn']) ?>
    </div>
    <div class="fixed-action-btn">
        <?= Html::submitButton('<i class="material-icons">save</i>', [
            'class' => 'btn-floating btn-large waves-effect waves-light tooltipped',
            'title' => 'Сохранить',
            'data-position' => 'left',
            'data-tooltip' => 'Сохранить',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
