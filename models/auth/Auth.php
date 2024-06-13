<?php
namespace app\models\auth;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

class Auth extends ActiveRecord
{

	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_token}}';
    }


}