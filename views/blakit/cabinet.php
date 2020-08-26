<?php
$this->title = 'История заказов';

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
            <div class="shops_shop_banner_nav_right_grid1 history_con">
                <ul class="user_orders history_blakit">
                    <?php if(!empty($orders)):?>
                    <p class="header_history">Заказы по домашнему текстилю</p>
                    <p class="time_order_info">-</p>
                    <?php foreach($orders as $order):?>
                    <li data-toggle="collapse" class="collapse-button" data-target="#<?=$order->id; ?>">
                        <p class = "number_order">№ <?=$order->id; ?></p>
                        <div>
                            <p class = "status_order"><?=$order->status?'<span class = "text-success">Сформирован</span>' : '<span class = "text-danger">На обработке</span>'?></p>
                            <p>|</p>
                            <p class = "time_order"><?=$order->time_order;?></p>
                            <span id="#<?=$order->id; ?>" class="glyphicon glyphicon-menu-down"></span>
                        </div>
                    </li>
                        <div id="<?=$order->id; ?>" class="collapse">
                            <?php $order_items = \app\models\OrderItems::find()->where(['order_id' => $order->id])->all(); ?>
                            <ul class="user_orders_info">
                                <?php foreach($order_items as $item):?>
                                <li>
                                    <div>
                                        <p class="product_name"><?=$item->name; ?></p>
                                        <p>Код: <?=$item->code; ?> Артикул: <?=$item->code_a; ?> Модель: <?=$item->model; ?> Номер ткани: <?=$item->fabric_number; ?> Номер рисунка: <?=$item->fabric_image; ?></p>
                                    </div>
                                    <div>
                                        <?php if ($order->status == 1) :?>
                                        <label>Отменено: <?=$item->cancel_count;?></label>
                                        <?php endif; ?>
                                        <p>Количество: <?=$item->qty; ?> шт.</p>
                                        <p>Цена: <?=realPrice($item->barcode); ?> BYN</p>
                                    </div>
                                </li>
                                <?php endforeach?>
                            </ul>
                        </div>
                    <?php endforeach?>
                    <?php else:?>
                    <p>Заказы по домашнему текстилю</p>
                    <p class="error_history">
                        Отсутствуют заказы по данной категории
                    </p>
                    <?php endif;?>
                </ul>
                <ul class="user_orders history_food">
                    <?php if(!empty($food_orders)):?>
                        <p class="header_history">Заказы по продуктам питания</p>
                        <p class="time_order_info">Выдача заказов производится на следующий рабочий день с момента оформления заказа. <br> Пункт выдачи - столовая МСК-1 (с 14:30 до 17:00). Телефон для справок: 217-95-10</p>
                        <?php foreach($food_orders as $order):?>
                            <li data-toggle="collapse" class="collapse-button" data-target="#<?=$order->id.'food'?>">
                                <p class = "number_order">№ <?=$order->id; ?></p>
                                <div>
                                    <p class = "status_order"><?=$order->status?'<span class = "text-success">Сформирован</span>' : '<span class = "text-danger">На обработке</span>'?></p>
                                    <p>|</p>
                                    <p class = "time_order"><?=$order->time_order;?></p>
                                    <span id="#<?=$order->id.'food'?>" class="glyphicon glyphicon-menu-down"></span>
                                </div>
                            </li>
                            <div id="<?=$order->id.'food' ?>" class="collapse">
                                <?php $order_items = \app\models\Food_order_items::find()->where(['order_id' => $order->id])->all(); ?>
                                <ul class="user_orders_info">
                                    <?php foreach($order_items as $item):?>
                                        <?php $cur_product = \app\models\Food_products::findOne(['id' => $item->product_id])  ?>
                                        <li>
                                            <div>
                                                <p class="product_name"><?=$cur_product->name;?></p>
                                                <p>Код товара: <?=$item->product_id;?></p>
                                            </div>
                                            <div>
                                                <?php if ($order->status == 1) :?>
                                                    <label>Отменено: <?=$item->cancel_count;?></label>
                                                <?php endif; ?>
                                                <p>Количество: <?=$item->qty; ?> шт.</p>
                                                <?php if ($cur_product->weighted == 1) :?>
                                                <p>Цена за кг: <?=$cur_product->price_per_kg; ?> BYN</p>
                                                <?php else: ?>
                                                    <p>Цена за шт: <?=$cur_product->price_per_kg; ?> BYN</p>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    <?php endforeach?>
                                </ul>
                            </div>
                        <?php endforeach?>
                    <?php else:?>
                        <p>Заказы по продуктам питания</p>
                        <p class="error_history">
                            Отсутствуют заказы по данной категории
                        </p>
                    <?php endif;?>
                </ul>
            </div>

        </div>
    </div>

    <div class="clearfix"></div>
</div>


