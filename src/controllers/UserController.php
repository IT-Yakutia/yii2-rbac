<?php

namespace ityakutia\rbac\controllers;

use common\models\User;
use ityakutia\rbac\models\CreateUserForm;
use Yii;
use ityakutia\rbac\models\UserSearch;
use ityakutia\rbac\models\AssignmentForm;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
	                    'permissions' => ['rbac_users']
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

    /**
     * Lists all Catalog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Catalog model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionPermit($id)
    {
        $model = new AssignmentForm();
        $model->user_id = $id;
        
        if (
			$model->load(Yii::$app->request->post())
			&& $model->validate()
            && $model->updateAssignments()
        ) {
            Yii::$app->session->setFlash('success', 'Роли успешно изменены.');
	        return $this->redirect(['index']);
        }

        return $this->render('permit', [
            'model' => $model,
            'user' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
	    $model = new CreateUserForm();

		if (
			Yii::$app->request->isPost
			&& $model->load(Yii::$app->request->post())
			&& $model->createUser()
		) {
			Yii::$app->session->setFlash('success', 'Пользователь успешно создан!');
			return $this->redirect(['index']);
		}

        return $this->render('create', [
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        if (($model = User::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
