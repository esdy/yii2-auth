<?php
namespace app\models\auth;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;


//models
use app\models\common\ActivityLog;


class GoogleAuth extends ActiveRecord
{

	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_token}}';
    }

	// Google Authentication
    public function googleAuth($payload)
    {
	

        /* @var Auth $auth */
        $auth = GoogleAuth::find()->where([
            'source' => 'google',
            'source_id' => $payload['sub'],
        ])->limit(1)->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                /* @var User $user */
                $user = User::findIdentity($auth->user_id);
                Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
            } else { // signup
                if ($payload['email'] !== null && User::find()->where(['email' => $payload['email']])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $this->client->getTitle()]),
                    ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'username' => $payload['email'],
                        'firstname' => $payload['given_name'],
                        'lastname' => $payload['family_name'],
                        'email' => $payload['email'],
                        'user_image' => $payload['picture'],
                        'password_hash' => $password,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
                        'status' => User::STATUS_ACTIVE // make sure you set status properly
                    ]);

		
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();

                    $transaction = User::getDb()->beginTransaction();

                    if ($user->save()) {
						// Add other functionalities like updating another table upon successful user login/registration. 
						// $model_name =  new ModelName();
						// $model_name->newMethodInModel($user->id, $another_param_if_any);
						
                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => 'google',
                            'source_id' => (string)$payload['sub'],
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
                        } else {
                            Yii::$app->getSession()->setFlash('error', [
                                Yii::t('app', 'Unable to save {client} account: {errors}', [
                                    'client' => 'Google',
                                    'errors' => json_encode($auth->getErrors()),
                                ]),
                            ]);
                        }
						ActivityLog::log("New User registered via google",$user->id, 0);

                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save user: {errors}', [
                                'client' => 'Google',
                                'errors' => json_encode($user->getErrors()),
                            ]),
                        ]);
                    }
					
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => 'google',
                    'source_id' => (string)$payload['sub'],
                ]);
                if ($auth->save()) {
                    /** @var User $user */
                    $user = $auth->user;
                    Yii::$app->getSession()->setFlash('success', [
                        Yii::t('app', 'Linked {client} account.', [
                            'client' => 'Google'
                        ]),
                    ]);
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', 'Unable to link {client} account: {errors}', [
                            'client' => 'Google',
                            'errors' => json_encode($auth->getErrors()),
                        ]),
                    ]);
                }
            } else { // there's existing auth
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app',
                        'Unable to link {client} account. There is another user using it.',
                        ['client' => 'Google']),
                ]);
            }
        }
    }	

}