<?php

/* @var yii\web\View $this */
/* @var ityakutia\rbac\models\PermissionForm $model */

$this->title = 'Новые права';
// $this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">
    <div class="row">
        <div class="col s12">
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
        </div>
    </div>
</div>
