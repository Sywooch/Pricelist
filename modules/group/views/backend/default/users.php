<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\components\grid\ActionColumn;
use app\modules\user\models\backend\User;
use app\components\grid\SetColumn;
use app\components\grid\LinkColumn;
use kartik\date\DatePicker;
use app\modules\group\Module;
use kartik\sortinput\SortableInput;
use app\components\widgets\LinkedItemsWidget;
use app\modules\group\models\Group;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('group', 'GROUP_USERS_MANAGE');
$this->params['breadcrumbs'][] = ['label' => Module::t('group', 'GROUPS_TITLE'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $group->title, 'url' => ['view', 'id' => $group->id]];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('
    $(".list-group-item").click(function (event) {
        event.preventDefault();
        $("#users a.list-group-item.active").removeClass("active");
        $(this).addClass("active");
    });
');
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="alert alert-info">
        <p class="col-lg-1 col-md-1 col-sm-2">
            <span class="glyphicon glyphicon-info-sign" style="font-size: 48px;"></span>
        </p>
        <p class="col-lg-11 col-md-11 col-sm-10">
            <p><?= Module::t('group', 'MANAGE_USERS_HINT {from} {to}', [
                'from' => Module::t('group', 'ALL_USERS'),
                'to' => Module::t('group', 'GROUP_USERS'),
            ]) ?></p>
        </p>
    </div>
    <div class="row">
        
            <div class="col-lg-3 col-md-3">
        <h5 class="text-center"><b>Пользователи</b></h5>
        <?= LinkedItemsWidget::widget([
            'links' => \yii\helpers\ArrayHelper::map(\app\modules\user\models\common\User::find()->select(['id', 'username'])->asArray()->all(), 'id', 'username'),
            'options' => ['id' => 'users'],
            'selectedKey' => 7
        ]) ?>
    </div>
        
    <div class="col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-2 col-sm-5">
        <h5 class="text-center"><b><?= Module::t('group', 'GROUP_USERS') ?></b></h5>
        <?= SortableInput::widget([
            'name'=>'group-users',
            'items' => $groupUsers,
            'hideInput' => false,
            'sortableOptions' => [
                'connected' => true,
                'itemOptions' => ['class'=>'alert alert-success'],
                'options' => ['style' => 'min-height: 50px'],
            ],
            'options' => [
                'class' => 'form-control', 
                'readonly' => true,
                'onchange' => '$.post( "' . Yii::$app->urlManager->createUrl(['group/user-change', 'id' => $group->id]). '", function (data) {
                    alert( data );
                    })'
            ]
        ]);?>
        </div>
        <div class="col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-2 col-sm-5 col-sm-offset-2">
            <h5 class="text-center"><b><?= Module::t('group', 'ALL_USERS') ?></b></h5>
        <?= SortableInput::widget([
            'name'=>'all-users',
            'items' => $allUsers,
            'hideInput' => false,
            'sortableOptions' => [
                'itemOptions'=>['class'=>'alert alert-info'],
                'connected'=>true,
                'options' => ['style' => 'min-height: 50px'],
            ],
            'options' => ['class'=>'form-control', 'readonly'=>true]
        ]);?>
        </div>
    </div>

</div>