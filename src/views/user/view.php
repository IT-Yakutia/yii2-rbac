<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var yii\web\View $this */
/* @var common\models\User $model */

$this->title = $model->username;
// $this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="row">
        <div class="col s12">
            <h1><?= Html::encode($this->title) ?></h1>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'username',
                    'email:email',
                    [
                        'attribute' => 'created_at',
                        'value' => function($model){
                            return Yii::$app->formatter->asDatetime($model->created_at);
                        }
                    ],
                    [
                        'attribute' => 'updated_at',
                        'value' => function($model){
                            return Yii::$app->formatter->asDatetime($model->updated_at);
                        }
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
