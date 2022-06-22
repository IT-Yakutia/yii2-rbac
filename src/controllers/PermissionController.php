<?php

namespace ityakutia\rbac\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use ityakutia\rbac\models\PermissionForm;

/**
 * CatalogController implements the CRUD actions for Catalog model.
 */
class PermissionController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin', 'rbac_permissions']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $descriptionfilter = Yii::$app->request->getQueryParam('filterdescription', '');
        $namefilter = Yii::$app->request->getQueryParam('filtername', '');

        $searchModel = ['name' => $namefilter, 'description' => $descriptionfilter];
        $model = new PermissionForm();
        $dataProvider = $model->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new PermissionForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Права успешно записаны.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка!');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($name)
    {
        $model = PermissionForm::getPermit($name);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->update($name)) {
                Yii::$app->session->setFlash('success', 'Права успешно записаны.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка!');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($name)
    {
        if (PermissionForm::delete($name)) {
            Yii::$app->session->setFlash('success', 'Право успешно удален.');
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка!');
        }

        return $this->redirect(['index']);
    }
}
