<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Обратная связь';
$user = \app\models\Users::findOne(['id'=>Yii::$app->user->identity->getId()]);

?>

<div class="products-breadcrumb">
    <div class="container">
        <ul>
            <li><i class="fa fa-home" aria-hidden="true"></i><a href="<?= \yii\helpers\Url::to(['site/index'])?>">Главная</a><span>|</span></li>
            <li><?= $this->title;?></li>
        </ul>
    </div>
</div>
<!-- banner -->
<div class="banner">

    <div class="shop_banner_nav_right w-cart-view">
        <div class="shops_shop_banner_nav_right_grid">
            <h3><?= $this->title;?></h3>
            <div class="shops_shop_banner_nav_right_grid1">
                <ul class="user_orders">
                    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

                        <div class="alert alert-success">
                            Спасибо за Ваше обращение!
                        </div>

                    <?php else: ?>

                    <div class="feedback-text">
                        <p class="text-center">
                            Если Вы хотите оставить свои предложения по работе сайта или обратиться по другим вопросам, воспользуйтесь формой ниже.
                        </p>
                        <p class="text-center">
                            По желанию Вы можете оставить Ваш номер телефона и(или) электронную почту.
                        </p>
                    </div>
                    <div class="row feedback-con">
                            <div class="col-lg-6">
                                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                                            <div style="display: none">
                                                <?= $form->field($model, 'user_id')->textInput(['value' => $user->id, 'readonly' => 'readonly'])?>
                                            </div>
                                            <?= $form->field($model, 'name')->textInput(['value' => $user->fio, 'readonly' => 'readonly'])?>
                                            <?= $form->field($model, 'tel')->textInput()?>
                                            <?= $form->field($model, 'email')->textInput()?>
                                            <?= $form->field($model, 'text')->textarea(['rows' => 6])?>
                                            <div class="form-group">
                                                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                                            </div>
                                <?php ActiveForm::end(); ?>

                            </div>
                        </div>

                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>

    <div class="clearfix"></div>
</div>

