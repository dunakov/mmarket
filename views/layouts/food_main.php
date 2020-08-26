<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;

AdminAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta name="keywords" content="Maz Shop" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<section id="container">
    <!--header start-->
    <header class="header fixed-top clearfix">
        <!--logo start-->
        <div class="brand">
            <a href="<?= \yii\helpers\Url::to(['foodadmin/orders', 'type' => 'new'])?>" class="logo">
                ADMIN
            </a>
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars"></div>
            </div>
        </div>
        <!--logo end-->
        <div class="nav notify-row" id="top_menu">
            <!--  notification start -->
            <ul class="nav top-menu">

            </ul>
            <!--  notification end -->
        </div>
        <div class="top-nav clearfix">
            <!--search & user info start-->
            <ul class="nav pull-right top-menu">

                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <?= \yii\helpers\Html::img("@web/images/2.png", ['alt' => 'admin_ico']) ?>
                        <span class="username"><?=Yii::$app->user->identity->login?></span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <li><a href="#"><i class=" fa fa-suitcase"></i><?=Yii::$app->user->identity->login?></a></li>
                        <li><a data-method="post" href="<?= \yii\helpers\Url::to(['/site/logout'])?>"><i class="fa fa-key"></i> Выйти</a></li>
                    </ul>
                </li>
                <!-- user login dropdown end -->

            </ul>
            <!--search & user info end-->
        </div>
    </header>

    <aside>
        <div id="sidebar" class="nav-collapse">
            <!-- sidebar menu start-->
            <div class="leftside-navigation">
                <ul class="sidebar-menu" id="nav-accordion">
                    <li class="sub-menu">
                        <a class="<?=getActive('orders');?>" href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Заказы</span>
                        </a>
                        <ul class="sub">
                            <li><a class="<?php if(@$_GET['type'] == 'new') {echo 'active';} ?>" href="<?= \yii\helpers\Url::to(['/foodadmin/orders', 'type' => 'new'])?>">Новые</a></li>
                            <li><a class="<?php if(@$_GET['type'] == 'processed') {echo 'active';} ?>" href="<?= \yii\helpers\Url::to(['/foodadmin/orders', 'type' => 'processed'])?>">Обработанные</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a class="<?=getActive('view');?><?=getActive('update');?><?=getActive('create');?>" href="javascript:;">
                            <i class="fa fa-database"></i>
                            <span>Товары</span>
                        </a>
                        <ul class="sub">
                            <li><a class="<?=getActive('view');?>" href="<?= \yii\helpers\Url::to(['/foodadmin/view'])?>">Просмотр</a></li>
                            <li><a class="<?=getActive('create');?>" href="<?= \yii\helpers\Url::to(['/foodadmin/create'])?>">Добавление</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="<?=getActive('messages');?>"" href="<?= \yii\helpers\Url::to(['/foodadmin/messages'])?>">
                            <i class="fa fa-envelope"></i>
                            <span>Сообщения</span>
                        </a>
                    </li>
                    <li>
                        <a class="<?=getActive('export');?>"" href="<?= \yii\helpers\Url::to(['/foodadmin/export'])?>">
                        <i class="fa fa-file-excel-o"></i>
                        <span>Экспорт заказов</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->
    <!--main content start-->
    <?=$content;?>
    <!--main content end-->
</section>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
