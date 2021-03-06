<?php

use app\modules\user\Module;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\user\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Module::t('user', 'USER_LOG_IN_TITLE');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-default-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Module::t('user', 'USER_LOG_IN_SUBTITLE') ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    <?= Module::t('user', 'USER_LOG_IN_HINT_RESET') ?><?= Html::a(Module::t('user', 'LINK_RESET_IT'), ['password-reset-request']) ?>.
                </div>

                <div class="form-group">
                    <?= Html::submitButton(Module::t('user', 'BUTTON_LOGIN'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>