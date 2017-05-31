<?php

namespace app\modules\main\controllers\backend;

use Yii;
use app\modules\main\models\Group;
use app\modules\main\models\search\GroupSearch;
use app\modules\user\models\common\Profile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends Controller
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
        ];
    }

    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Group model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $group = $this->findModel($id);
        $users = new ArrayDataProvider([
            'allModels' => $group->profiles,
            'sort' => false,
            'pagination' => false,
        ]);
        
        return $this->render('view', [
            'group' => $group,
            'users' => $users,
        ]);
    }

    /**
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Group();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Disable/Enable an existing Group model.
     * @param integer $id
     * @return mixed
     */
    public function actionChange($id, $view)
    {
        $model = $this->findModel($id);
        $model->changeActivity();

        return $this->redirect([$view, 'id' => $id]);
    } 

    /**
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Manage Group Users
     * @param integer $id
     * @return string
     */
    public function actionUser($id)
    {
        $group = $this->findModel($id);
        $groupUsers = $group->preparedForSIWActiveProfiles();
        $allUsers = Profile::preparedForSIWActiveProfiles();
        
        return $this->render('user', [
                'group' => $group,
                'allUsers' => array_diff_key($allUsers, $groupUsers),
                'groupUsers' => $groupUsers,
            ]);
    }
    
    /**
     * Manage Groups Users
     * @return string
     */
    public function actionUsers($id = -1)
    {
        $groups = ArrayHelper::map(Group::find()->select(['id', 'title'])->asArray()->all(), 'id', 'title');
        if ($id == -1) {
            $id = key($groups);
        }
        
        return $this->render('user', [
                'groups' => $groups,
                'selectedGroup' => $id,
            ]);
    }
}