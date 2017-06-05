<?php
 
use yii\helpers\Html;
use app\modules\admin\Module;
 
/* @var $this yii\web\View */
/* @var $model \app\modules\user\models\User */
 
$this->title = Module::t('admin', 'ADMIN_TITLE');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-default-index">
    
    <h1><?= Html::encode($this->title) ?></h1>
 
    <p>
        <div class="btn-group" role="group">
            <?= Html::a(Module::t('admin', 'LINK_ADMIN_USERS'), ['user/default/index'], ['class' => 'btn btn-default']) ?>
            <?= Html::a(Module::t('admin', 'LINK_ADMIN_GROUPS'), ['group/default/index'], ['class' => 'btn btn-default']) ?>
            <?= Html::a(Module::t('admin', 'LINK_ADMIN_WAREHOUSES'), ['warehouse/default/index'], ['class' => 'btn btn-default']) ?>
        </div>
    </p>
    <br><br><br>
    <p>
        <?= Html::a(Module::t('admin', 'LINK_ADMIN_ROLES'), ['user/roles/index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Module::t('admin', 'LINK_ADMIN_USERS'), ['user/default/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Module::t('admin', 'LINK_ADMIN_ROLES'), ['user/roles/index'], ['class' => 'btn btn-success']) ?>
    </p>
    
</div>
