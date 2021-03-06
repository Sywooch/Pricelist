<?php

/* @var $this yii\web\View */
/* @var $user app\modules\user\models\User */

use yii\helpers\Html;
use app\modules\user\Module;
 
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/email-confirm', 'token' => $user->email_confirm_token]);
?>
 
<div class="email-confirm">
    
    <p><?= Module::t('user', 'HELLO {username}', ['username' => $user->username]) ?></p>

    <p><?= Module::t('user', 'FOLLOW_TO_CONFIRM_EMAIL') ?></p>

    <?= Html::a(Html::encode($confirmLink), $confirmLink) ?>

    <p><?= Module::t('user', 'IGNORE_IF_DO_NOT_REGISTER') ?></p>

</div>