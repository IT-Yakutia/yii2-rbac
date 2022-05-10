<?php

/* @var yii\web\View $this */
/* @var ityakutia\rbac\models\CreateUserForm $model */

$this->title = 'Новый пользователь';
?>
<div class="user-create">
    <div class="row">
        <div class="col s12">
            <?= $this->render('_createform', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>