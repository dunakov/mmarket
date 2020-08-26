<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Users;
use app\models\Food_credit;
use app\models\Orders;


AppAsset::register($this);
$user = Users::findOne(['id'=>Yii::$app->user->identity->getId()]);
$sumUser= Orders::find()->where(['user_id' => \Yii::$app->user->getId()])->andWhere("MONTH(`time_order`) = MONTH(NOW()) AND YEAR(`time_order`) = YEAR(NOW())")->sum('sum');
$userlimit = Users::find()->where(['id' => \Yii::$app->user->getId()])->one();

$str_tab = strval($userlimit->login);

if ($str_tab[0] == 0)
{
    $str_tab_up = substr($str_tab, 1);
    $food_credit = Food_credit::find()->where(['WSH_TN' => $str_tab_up])->one();
}
else
{
    $food_credit = Food_credit::find()->where(['WSH_TN' => $userlimit->login])->one();
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta name="keywords" content="Maz Shop" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); } </script>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap_head_content_foot">
    <div class="head_content">
<div class="logo_products">
    <div class="menu-main">
        <div class="shops_logo_products_left">
            <a href="<?= \yii\helpers\Url::to(['site/index'])?>"><?= \yii\helpers\Html::img('@web/images/maz-market.png', ['alt'=>'mar-market','height' => 43]);?></a>
        </div>

        <div class="shops_logo_products_left2">
            <ul class="phone_email">
                <li class="dropdown user-menu"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= \yii\helpers\Html::img('@web/images/'.'user.png', ['alt'=>'user', 'class' => 'user_img']);?></a>
                    <ul class="dropdown-menu">
                        <li class="name_us"><a><?=$user->fio?></a><a data-method="post" href="<?= \yii\helpers\Url::to(['/site/logout'])?>">Выйти</a></li>
                        <li><a>Остаток(текстиль) : <?=$userlimit->limit_sum - round($sumUser, 2);?> р.</a></li>
                        <li><a>Остаток(питание) : <?=isset($food_credit->CREDIT)?$food_credit->CREDIT:0?> р.</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['blakit/cabinet'])?>">История заказов</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/feedback'])?>">Обратная связь</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['site/pickup'])?>">Пункт выдачи</a></li>
                    </ul>
                </li>
                <li class="cart-li dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="getCart()">
                        <i class="shopping-cart" aria-hidden="true">
                            <?php
                            if (isset($_SESSION['cart.qty']) && ($_SESSION['cart.qty']) !== 0)
                                {
                                    if ($_SESSION['cart.qty'] < 10)
                                    {
                                        echo '<i class="cart_qty">'.$_SESSION['cart.qty'].'</i>';
                                    }
                                    else if ($_SESSION['cart.qty'] >= 10)
                                    {
                                        echo '<i class="cart_qty double-qty">'.$_SESSION['cart.qty'].'</i>';
                                    }

                                }
                            else
                                {
                                    echo '<i class="cart_qty empty-cart">'.'0'.'</i>';
                                }
                            ?>
                        </i>
                    </a>
                    <ul class="dropdown-menu cart-drop" id="cart">
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="logo_products2">
    <div class="menu-main">
        <div class="shops_logo_products_left">
            <a href="<?= \yii\helpers\Url::to(['site/index'])?>"><?= \yii\helpers\Html::img('@web/images/maz-market.png', ['alt'=>'mar-market','height' => 43]);?></a>
        </div>
        <div class="shops_logo_products_left2">
            <ul class="phone_email">
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= \yii\helpers\Html::img('@web/images/'.'user.png', ['alt'=>'user', 'class' => 'user_img']);?></a>
                    <ul class="dropdown-menu">
                        <li class="name_us"><a><?=$user->fio?></a><a data-method="post" href="<?= \yii\helpers\Url::to(['/site/logout'])?>">Выйти</a></li>
                        <li><a>Остаток(текстиль) : <?=$userlimit->limit_sum - round($sumUser, 2);?> р.</a></li>
                        <li><a>Остаток(питание) : <?=isset($food_credit->CREDIT)?$food_credit->CREDIT:0?> р.</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['blakit/cabinet'])?>">История заказов</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/feedback'])?>">Обратная связь</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['site/pickup'])?>">Пункт выдачи</a></li>
                    </ul>
                </li>
                <li class="cart-li dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="getCart()">
                        <i class="shopping-cart" aria-hidden="true">
                            <?php
                            if (isset($_SESSION['cart.qty']) && ($_SESSION['cart.qty']) !== 0)
                            {
                                if ($_SESSION['cart.qty'] < 10)
                                {
                                    echo '<i class="cart_qty">'.$_SESSION['cart.qty'].'</i>';
                                }
                                else if ($_SESSION['cart.qty'] >= 10)
                                {
                                    echo '<i class="cart_qty double-qty">'.$_SESSION['cart.qty'].'</i>';
                                }

                            }
                            else
                            {
                                echo '<i class="cart_qty empty-cart">'.'0'.'</i>';
                            }
                            ?>
                        </i>
                    </a>
                    <ul class="dropdown-menu cart-drop" id="cart-1">
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<?= $content ?>

    </div>
<div class="footer">
    <div class="container">

        <!--<div class="col-md-6 w3_footer_grid">
            <h3>Торговый дом Маз</h3>
            <ul class="w3_footer_grid_list1">
                <li>+375(17)3956296</li>
                <li>+375(29)6859798</li>
                <li>+375(44)7956524</li>
                <li>Понедельник - Пятница: 8:00 - 16:30;</li>
            </ul>
        </div>
        <div class="clearfix"> </div>-->
    </div>
    <p class="oao_maz">
        <a href="<?= \yii\helpers\Url::to(['/feedback'])?>">Обратная связь</a>
        <a href="http://maz.by/" target="_blank">ОАО "МАЗ" - управляющая компания холдинга «БЕЛАВТОМАЗ»</a>
    </p>
</div>

<div id="cart" class="fade modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2>Корзина</h2>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Продолжить покупки</button>
                <a href="/cart/view" class="btn btn-success">Оформить заказ</a>
                <button type="button" class="btn btn-danger" id="clearcart">Очистить корзину</button>
            </div>
        </div>
    </div>
</div>

<div id="error-modal" class="fade modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2>Информация</h2>
            </div>
            <div class="modal-body">
                <p>Вы привысили месячный лимит (<?=(($userlimit->limit_sum - round($sumUser, 2))). ' BYN'?>) либо такого количества товара нет на складе</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Продолжить покупки</button>
            </div>
        </div>
    </div>
</div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
