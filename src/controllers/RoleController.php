<?php

namespace ityakutia\rbac\controllers;

use ityakutia\rbac\models\RoleForm;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * CatalogController implements the CRUD actions for Catalog model.
 */
class RoleController extends Controller
{
	/**
	 * @inheritdoc
	 */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
	                    'permissions' => ['rbac_roles']
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
        $dataProvider = RoleForm::all();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new RoleForm();

        if (
			$model->load(Yii::$app->request->post())
			&& $model->validate()
            && $model->save()
        ) {
            Yii::$app->session->setFlash('success', 'Роль успешно записана.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($name)
    {
        $model = RoleForm::getPermit($name);

        if (
			$model->load(Yii::$app->request->post())
			&& $model->validate()
            && $model->update($name)
        ) {
            Yii::$app->session->setFlash('success', 'Роль успешно записана.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($name)
    {
        if (RoleForm::delete($name)) {
            Yii::$app->session->setFlash('success', 'Роль успешно удалена.');
        }else{
            Yii::$app->session->setFlash('error', 'Ошибка!');
        }

	    return $this->redirect(['index']);
    }
}
