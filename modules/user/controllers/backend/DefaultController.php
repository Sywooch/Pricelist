<?php

namespace app\modules\user\controllers\backend;

use Yii;
use app\modules\user\models\backend\User;
use app\modules\user\models\common\Profile;
use app\modules\user\models\backend\search\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\admin\rbac\Rbac;
use app\modules\user\forms\backend\UserCreateForm;

/**
 * DefaultController implements the CRUD actions for User model.
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::PERMISSION_ADMINISTRATION],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $dataProvider->pagination = false;

        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $user = $this->findModel($id);
        $profile = $user->profile;
        
        return $this->render('view', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $user = new User();
        $user->scenario = User::SCENARIO_ADMIN_CREATE;
        $user->status = User::STATUS_ACTIVE;
        
        $profile = new Profile();
        
        if ($user->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {
            if ($user->validate() && $profile->validate()) {
                $user->save(false);
                $profile->user_id = $user->id;
                $profile->save(false);
                return $this->redirect(['view', 'id' => $user->id]);
            }
        } else {
            return $this->render('create', [
                'user' => $user,
                'profile' => $profile,
            ]);
        }       
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $view = 'view')
    {
        $user = $this->findModel($id);
        $user->scenario = User::SCENARIO_ADMIN_UPDATE;
        $profile = $user->profile;

        if ($user->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {
            if ($user->validate() && $profile->validate()) {
                $user->save(false);
                $profile->save(false);
                return $this->redirect([$view, 'id' => $user->id]);
            }
        } else {
            return $this->render('update', [
                'user' => $user,
                'profile' => $profile,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Block User
     */
    public function actionBlock($id, $view)
    {
        $model = $this->findModel($id);
        $model->block();
        
        return $this->redirect([$view, 'id' => $id]);
    }
    
    /**
     * Unblock User
     */
    public function actionUnblock($id, $view)
    {
        $model = $this->findModel($id);
        $model->unblock();
        
        return $this->redirect([$view, 'id' => $id]);
    }    
}
