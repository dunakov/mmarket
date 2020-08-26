<?php
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;
$this->title = 'Создание товара';

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<section id="main-content">
    <section class="wrapper">
        <div class="col-md-12 stats-info stats-last widget-shadow">
            <div class="stats-last-agile">
                <div class="stats-title">
                    <h4 class="title"><?=$this->title ?></h4>
                </div>

                <ul class="user_orders">
                    <?php $form = ActiveForm::begin([
                        'id' => 'update-form',
                        'options' => ['class' => 'form-horizontal'],
                    ]); ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Наименование товара') ?>
                    <?= $form->field($model, 'image')->widget(InputFile::className(), [
                        'language'      => 'ru',
                        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'options'       => ['class' => 'form-control'],
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'multiple'      => false       // возможность выбора нескольких файлов
                    ])->label('Изображение')?>
                    <?= $form->field($model, 'price_per_kg')->textInput(['maxlength' => true])->label('Цена за шт/кг') ?>
                    <?= $form->field($model, 'weighted')->dropDownList(['0'=>'Штучный','1'=> 'Взвешиваемый'])->label('Тип товара'); ?>
                    <?php if ($model->weighted == 0) :?>
                        <div class="weight_fields" style="display: none">
                            <?= $form->field($model, 'min_weight')->textInput(['maxlength' => true])->label('Минимальный вес') ?>
                            <?= $form->field($model, 'max_weight')->textInput(['maxlength' => true])->label('Максимальный вес') ?>
                        </div>
                    <?php else :?>
                        <div class="weight_fields">
                            <?= $form->field($model, 'min_weight')->textInput(['maxlength' => true])->label('Минимальный вес') ?>
                            <?= $form->field($model, 'max_weight')->textInput(['maxlength' => true])->label('Максимальный вес') ?>
                        </div>
                    <?php endif;?>

                    <?= $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Food_categories::find()->all(), 'id','name'), ['style'=>'font-family: \'Exo 2\', sans-serif; color: #0f0f0f; font-size:17px'])->label('Категория')?>
                    <?= $form->field($model, 'qty')->textInput(['maxlength' => true])->label('Количество') ?>
                    <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание') ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </ul>

            </div>
        </div>
        <div class="clearfix"> </div>
    </section>
    <!-- footer -->
    <div class="footer">
        <div class="wthree-copyright">
            <p>Admin Control Center</p>
        </div>
    </div>
    <!-- / footer -->
</section>

