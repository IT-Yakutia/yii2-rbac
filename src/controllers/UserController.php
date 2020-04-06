<?php

namespace ityakutia\rbac\controllers;

use Yii;
use ityakutia\rbac\models\User;
use ityakutia\rbac\models\UserSearch;
use ityakutia\rbac\models\AssignmentForm;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CatalogController implements the CRUD actions for Catalog model.
 */
class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->updateAssignments()) {
                Yii::$app->session->setFlash('success', 'Роли успешно изменены.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка!');
            }
        }

        return $this->render('permit', [
            'model' => $model,
            'user' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new User();
        $post = Yii::$app->request->post();

        if(!empty($post)){
            $model->email = $post['User']['email'];
            $model->username = $post['User']['email'];
            $model->password = $post['User']['password'];
                $model->generateAuthKey();
                $model->status = 10;
                if($model->save()) {
                    Yii::$app->session->setFlash('success', 'Пользователь успешно создан!');
                    return $this->redirect(['index']);
                }
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
