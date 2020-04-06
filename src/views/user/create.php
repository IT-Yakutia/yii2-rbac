<?php

/* @var $model ityakutia\rbac\models\User */

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