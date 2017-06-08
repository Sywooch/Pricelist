<?php

namespace app\modules\product;

use Yii;
use yii\filters\AccessControl;

/**
 * product module definition class
 */
class Module extends \yii\base\Module
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
 
    
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/product/' . $category, $message, $params, $language);
    }
}