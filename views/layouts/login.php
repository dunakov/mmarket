<?php
/**
 * Created by PhpStorm.
 * User: uit09
 * Date: 11.10.2019
 * Time: 14:38
 */



use yii\helpers\Html;


\app\assets\LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>
<div class="wrap">

    <div class="container">
        <?= $content ?>
    </div>
</div>
<?php $this->endBody() ?>
<?php $this->endPage() ?>