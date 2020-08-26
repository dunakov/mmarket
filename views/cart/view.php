<?php
$this->title = 'Оформление заказа';
$user = \app\models\Users::find()->where(['id' => Yii::$app->user->getId()])->one();


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
                <!--<h3><?/*= $this->title;*/?></h3>-->
                <div class="shops_shop_banner_nav_right_grid1">
                    <div class="user_details">
                        <p>Заказчик: </p>
                        <p><?=$user->fio; ?></p>
                        <p style="display: flex; margin-top: 10px">
                            <label style="padding-right: 10px" for="tel_view">Телефон:</label>
                            <?php if($user->user_tel != null && $user->user_tel != '') :?>
                                <input type="text"  style="width: 160px; text-align: center;" id="tel_view" value="<?=$user->user_tel;?>">
                                <?php else: ?>
                                <input type="text"  style="width: 160px; text-align: center;" id="tel_view">
                            <?php endif; ?>

                        </p>
                    </div>
                    <?php if (isset($error)) :?>
                        <?php if ($error == 803) :?>
                        <div class="panel panel-info panel-view">
                            <div class="panel-heading">Уведомление</div>
                            <div class="panel-body">
                                Уважаемый пользователь, на данный момент на складе осталось:
                                <ul>
                                    <?php foreach ($session_for as $item):?>
                                    <li><?=$item['name']?> в количестве <?=$item['qty']?> шт.</li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        </div>
                        <?php elseif ($error == 804) :?>
                            <div class="panel panel-info panel-view">
                                <div class="panel-heading">Уведомление</div>
                                <div class="panel-body">
                                    Уважаемый пользователь, на данный момент на складе не осталось нужных Вам товаров.
                                </div>
                            </div>
                        <?php elseif ($error == 805) :?>
                            <div class="panel panel-info panel-view">
                                <div class="panel-heading">Уведомление</div>
                                <div class="panel-body">
                                    Уважаемый пользователь, на данный момент на складе не осталось нужного количества Вам товаров.
                                </div>
                            </div>
                        <?php endif;?>

                    <?php endif;?>
                    <div class="order_details" id = "order_details">
                        <?php if(!empty($session['cart'])): ?>
                            <div class="cart-modal check-ord">

                                <div>
                                    <div class="header-cart">
                                        <div>Фото</div>
                                        <div>Наименование</div>
                                        <div>Кол-во</div>
                                        <div>Цена</div>
                                        <div></div>
                                    </div>
                                    <?php $footer_b = ''; $b_i = 0; $b_k = 0; $len = count($session['cart']);?>
                                    <?php foreach($session['cart'] as $id => $item):?>
                                        <?php $b_i++;?>
                                        <?php if (preg_replace('/[0-9]+/', '', $id) != 'food') :?>
                                            <?php if ($b_k == 0) :?>
                                                <div class="item-cart item-cart-name">
                                                    <p class="header_ch">Домашний текстиль</p>
                                                </div>
                                            <?php endif; ?>
                                            <?php $b_k++;?>
                                            <div class="item-cart">
                                                <div><?= \yii\helpers\Html::img("@web/images/{$item['img']}", ['alt' => $item['name'], 'height' => 50]) ?></div>
                                                <div><a href="<?= \yii\helpers\Url::to(['blakit/product', 'category' => preg_replace('/[0-9]+/', '', $id), 'id' => preg_replace('~\D+~','',$id)])?>"><?= \yii\helpers\StringHelper::truncateWords($item['name'], 10, '...')?></a></div>
                                                <div><button class="quont-minus">-</button><button class="quont-plus">+</button><input style="display: none" min="1" data-id="<?= $id?>" data-id_product ='<?=preg_replace('~\D+~','',$id);?>' data-category = '<?=preg_replace('/[0-9]+/', '', $id);?>' class="qty-number" type="number" value="<?= $item['qty']?>"></div>
                                                <div><span class="count-item"><?= $item['qty'].'x'?></span> <?= $item['price'].' BYN'?></div>
                                                <div title = "Удаление из корзины" class="cancel-item"><span data-id="<?= $id?>" data-id_product ='<?=preg_replace('~\D+~','',$id);?>' data-category = '<?=preg_replace('/[0-9]+/', '', $id);?>' class="fa fa-trash-o text-danger del-item" aria-hidden="true"></span></div>
                                            </div>
                                            <?php $footer_b = '<div class="total-cart"><div class="total-sum"><div>'.'Домашнего текстиля '.'на сумму:</div><div>'.$session['cart.sum']. ' BYN'.'</div></div></div>';
                                            ?>
                                        <?php endif; ?>
                                        <?php if ($b_i == $len) :?>
                                            <?=$footer_b;?>
                                        <?php endif;?>
                                    <?php endforeach?>

                                    <?php $footer_f = ''; $f_i = 0; $f_k = 0;?>
                                    <?php foreach($session['cart'] as $id => $item):?>
                                        <?php $f_i++;?>
                                        <?php if (preg_replace('/[0-9]+/', '', $id) == 'food') :?>
                                            <?php if ($f_k == 0) :?>
                                                <div class="item-cart item-cart-name">
                                                    <p class="header_ch">Продукты питания</p>
                                                </div>
                                            <?php endif; ?>
                                            <?php $f_k++;?>
                                            <div class="item-cart">
                                                <div>
                                                    <?php if (isset($item['img'])) :?>
                                                        <?php if ($item['img'] == null || $item['img'] == '') :?>
                                                            <?= \yii\helpers\Html::img('@web/images/'.'noimage.jpg', ['alt'=>$item['name'], 'height' => 50]);?>
                                                        <?php else: ?>
                                                            <?= \yii\helpers\Html::img('@web'.$item['img'], ['alt'=>$item['name'], 'height' => 50]);?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div><a href="<?= \yii\helpers\Url::to(['food/product', 'category' => preg_replace('/[0-9]+/', '', $id), 'id' => preg_replace('~\D+~','',$id)])?>"><?= \yii\helpers\StringHelper::truncateWords($item['name'], 10, '...')?></a></div>
                                                <div><button class="quont-minus">-</button><button class="quont-plus">+</button><input style="display: none" min="1" data-id="<?= $id?>" data-id_product ='<?=preg_replace('~\D+~','',$id);?>' data-category = '<?=preg_replace('/[0-9]+/', '', $id);?>' class="qty-number" type="number" value="<?= $item['qty']?>"></div>
                                                <?php if ($item['weighted'] == 1) :?>
                                                    <div class="price-food"><div><span class="count-item"><?= $item['qty']. ' x'?></span></div><div class="price-food_inf"><p><?=$item['packing_size'];?> кг</p><p><?=$item['price_per_kg'];?>р./кг.</p></div></div>
                                                <?php else: ?>
                                                    <div class="price-food"><div><span class="count-item"><?= $item['qty']. ' x'?></span></div><div class="price-food_inf"><p><?=$item['packing_size'];?></p><p><?=$item['price_per_kg'];?>р./шт.</p></div></div>                        <?php endif; ?>
                                                <div title = "Удаление из корзины" class="cancel-item"><span data-id="<?= $id?>" data-id_product ='<?=preg_replace('~\D+~','',$id);?>' data-category = '<?=preg_replace('/[0-9]+/', '', $id);?>' class="fa fa-trash-o text-danger del-item" aria-hidden="true"></span></div>
                                            </div>
                                            <?php $estimated_price = '<div class = "estimated_price">'.'Ориентировочная цена от '.$session['cart.min_sum'].' р.'.' до '.$session['cart.max_sum'].' р.';?>
                                            <?php $footer_f = '<div class="total-cart"><div class="total-sum"><div>*Итоговая сумма варьируется в зависимости от фасовки</div></div></div>';
                                            ?>
                                        <?php endif; ?>
                                        <?php if ($f_i == $len && isset($estimated_price) && isset($footer_f)) :?>
                                            <?=$estimated_price;?>
                                            <?=$footer_f;?>
                                        <?php endif;?>
                                    <?php endforeach?>

                                </div>
                            </div>

                        <?php else: ?>
                            <h2 class="text-center">Корзина пуста</h2>
                        <?php endif;?>
                    </div>

                </div>


                <?php if(!empty($session['cart']) && isset($session['cart']) && count($session['cart']) > 0): ?>
                    <div class="cart_order_div">
                        <a  class="cart_order" href="<?= \yii\helpers\Url::to(['cart/saveorder'])?>">Заказать</a>
                    </div>
                <?php endif;?>

            </div>
        </div>

        <div class="clearfix"></div>
    </div>


