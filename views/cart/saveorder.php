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
            <h3><?= $this->title;?></h3>
            <div class="shops_shop_banner_nav_right_grid1">
                <div class="save-user_details" style="font-family: none;">
                    <?php if (!isset($error)) :?>
                        <p>Уважаемый <?=$user->fio; ?></p>
                        <div class="text-ob">
                        <?php if(isset($order_id_f) && $order_id_b !='') :?>
                            <p style="text-align: left;"><?=$order_id_b;?></p>
                            <span class="danger center-block footer_save_order">При возникновении вопросов бращаться по телефонам: 218-91-46 (гор.) 8-029-603-84-73 (моб.) <br> звонить с 8:00 до 17:00 (обед: 12:30-13:30)</span>
                        <?php endif;?>
                        <?php if(isset($order_id_f) && $order_id_f !='') :?>
                            <p style="text-align: left;"><?=$order_id_f;?></p>
                            <span class="danger center-block footer_save_order"> Вам необходимо забрать заказ на следующий рабочий день.
                            <br>Пункт выдачи - столовая МСК-1 (с 14:30 до 17:00)</span>
                        <?php endif;?>

                    <?php else: ?>
                        <p>Уважаемый <?=$user->fio; ?></p>
                        <hr>
                        <span class="danger center-block">Товар, который Вы добавили в корзину отсутствует на cкладе или уже кем-то забророван</span>
                    <?php endif; ?>
                    </div>
                    <span class="danger text-right footer_save_order">Телефон для справок: 217-95-10</span>
                </div>

            </div>

        </div>
    </div>

    <div class="clearfix"></div>
</div>


