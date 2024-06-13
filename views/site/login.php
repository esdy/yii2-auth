<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ]) ?>

            <div class="form-group">
                <div>
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <div style="color:#999;">
                You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
                To modify the username/password, please check out the code <code>app\models\User::$users</code>.
            </div>

			<div class="row">
				<div class="col-6">
					<div id="buttonDiv"></div>
				</div>
			</div>
        </div>
    </div>
</div>


<script>
	const handleCredentialResponse = (response) => {
	  if(response.credential != null){
		  $.post({
			  type:'POST',
			  async:false,
			  data: {
					'gsitfavg': response.credential
			  },
			url:'<?= Yii::$app->urlManager->createUrl(['site/gsi']) ?>',
		  }).done(function(data){
			  location.reload()		
		  });  
	  }
	}
	
	window.onload = function () {
	  google.accounts.id.initialize({
		client_id: '<?=Yii::$app->params['googleClientId']?>',
		callback: handleCredentialResponse
	  });
	  google.accounts.id.renderButton(
		document.getElementById("buttonDiv"),
		{ theme: "outline", size: "large" }  // customization attributes
	  );
	  google.accounts.id.prompt(); // also display the One Tap dialog
	}

</script>