<?php



$this->title = 'Пункт выдачи по продуктам питания';

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
<div class="banner pickup-b">

    <div class="shop_banner_nav_right w-cart-view">
        <div class="shops_shop_banner_nav_right_grid">
            <h3><?= $this->title;?></h3>
            <div class="shops_shop_banner_nav_right_grid1">
                <ul class="user_orders">
                    <p class="pickup">Выдача заказов производится на следующий рабочий день с момента оформления заказа. <br> Пункт выдачи - столовая МСК-1 (с 14:30 до 17:00). Телефон для справок: 217-95-10</p>
                    <iframe src="https://yandex.by/map-widget/v1/?um=constructor:9f30ab0cd6284dd8d752d47690585b7ccf9423cc94d8fc7d4ee0685a8f9f94f7&amp;source=constructor" width="100%" height="513" frameborder="0"></iframe>
                </ul>
            </div>

        </div>
    </div>

    <div class="shop_banner_nav_right w-cart-view">
        <div class="shops_shop_banner_nav_right_grid">
            <h3><?= 'Пункт выдачи по домашнему текстилю';?></h3>
            <div class="shops_shop_banner_nav_right_grid1">
                <ul class="user_orders">
                    <p class="pickup">Обращаться по телефонам: 218-91-46 (гор.) 8-029-603-84-73 (моб.) <br> звонить с 8:00 до 17:00 (обед: 12:30-13:30)</p>


                </ul>
            </div>

        </div>
    </div>

    <div class="clearfix"></div>
</div>

