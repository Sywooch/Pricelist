<?php

use yii\helpers\Html;
use app\modules\main\Module;

/* @var $this yii\web\View */
/* @var $model app\modules\main\models\Group */

$this->title = Module::t('main', 'GROUP_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('main', 'GROUPS_TITLE'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
