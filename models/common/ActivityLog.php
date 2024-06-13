<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "activity_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $controller
 * @property string $action
 * @property string $description
 * @property string $cdate
 */
class ActivityLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['description'], 'string'],
            [['cdate'], 'safe'],
            [['controller', 'action'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'controller' => 'Controller',
            'action' => 'Action',
            'description' => 'Description',
            'cdate' => 'Crated Date',
        ];
    }

    /**
     * Activity log
     */	
	public static function log($description,$user_id=0,$externalID=0){
		
			
		$activity_log = new ActivityLog();
		$activity_log->user_id = $user_id;
		$activity_log->controller = Yii::$app->controller->id;
		$activity_log->action = Yii::$app->controller->action->id;
		$activity_log->description = $description;
		$activity_log->ip = Yii::$app->getRequest()->getUserIP();
		$activity_log->external_id = $externalID;
		$activity_log->version = Yii::$app->params['app_version'];
		$activity_log->save();
		
	}
}
