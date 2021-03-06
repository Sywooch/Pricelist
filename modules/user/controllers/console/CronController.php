<?php

namespace app\modules\user\controllers\console;
 
use app\modules\user\models\common\User;
use yii\console\Controller;
use yii\helpers\Console;
use Yii;
 
/**
 * Console crontab actions
 * 
 * Для автоматического удаления по планировщику задач Cron можно в файле /etc/cron.d/myapp запускать процесс в каждую полночь:
 * 0 0 * * * www-data /home/seokeys/htdoc/yii user/cron/remove-overdue >/dev/null
 */
class CronController extends Controller
{
    /**
     * @var \app\modules\user\Module
     */
    public $module;
 
    /**
     * Removes non-activated expired users
     */
    public function actionRemoveOverdue()
    {
        foreach (User::find()->overdue($this->module->emailConfirmTokenExpire)->each() as $user) {
            /** @var User $user */
            $this->stdout($user->username);
            if ($user->delete()) {
                Yii::info('Remove expired user ' . $user->username);
                $this->stdout(' OK', Console::FG_GREEN, Console::BOLD);
            } else {
                Yii::warning('Cannot remove expired user ' . $user->username);
                $this->stderr(' FAIL', Console::FG_RED, Console::BOLD);
            }
            $this->stdout(PHP_EOL);
        }
 
        $this->stdout('Done!', Console::FG_GREEN, Console::BOLD);
        $this->stdout(PHP_EOL);
    }
}