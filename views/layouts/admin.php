<?php
 
use app\modules\admin\Module;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
 
/* @var $this \yii\web\View */
/* @var $content string */
 
/** @var \yii\web\Controller $context */
$context = $this->context;
 
if (isset($this->params['breadcrumbs'])) {
    $panelBreadcrumbs = [['label' => Module::t('admin', 'ADMIN_TITLE'), 'url' => ['/admin/default/index']]];
    $breadcrumbs = $this->params['breadcrumbs'];
} else {
    $panelBreadcrumbs = [Module::t('admin', 'ADMIN_TITLE')];
    $breadcrumbs = [];
}
?>
<?php $this->beginContent('@app/views/layouts/layout.php'); ?>
 
<?php
NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'activateParents' => true,
    'items' => array_filter([
        ['label' => Yii::t('app', 'NAV_ADMIN'), 'url' => ['/admin/default/index']],
        ['label' => Yii::t('app', 'NAV_ADMIN_USERS'), 'url' => ['/admin/user/default/index'], 'active' => $context->module->id == 'user'],
        ['label' => Yii::t('app', 'NAV_LOGOUT'), 'url' => ['/user/default/logout'], 'linkOptions' => ['data-method' => 'post']]
    ]),
]);
NavBar::end();
?>
 
<div class="container">
    <?= Breadcrumbs::widget([
        'links' => ArrayHelper::merge($panelBreadcrumbs, $breadcrumbs),
    ]) ?>
    <?= $content ?>
</div>
 
<?php $this->endContent(); ?>