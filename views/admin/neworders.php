<?php
$this->title = 'Новые заказы';
?>
<section id="main-content">
    <section class="wrapper">
            <div class="col-md-12 stats-info stats-last widget-shadow">
                <div class="stats-last-agile">
                    <div class="stats-title">
                        <h4 class="title">Новые заказы</h4>
                    </div>

                    <ul class="user_orders">
                        <?php foreach($model  as $order):?>
                            <?php $user = \app\models\Users::findOne(['id' => $order->user_id]) ?>
                            <li data-toggle="collapse" class="collapse-button" data-target="#<?=$order->id; ?>">
                                <p class = "number_order">№ <?=$order->id; ?> - <?=$user->fio ?> Тел: <?=($user->user_tel != null && $user->user_tel != '') ? $user->user_tel : 'Не указан'?></p>
                                <div>
                                    <p class = "status_order"><span class="label label-warning">Новый</span></p>
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
                                                <p>Артикул: <?=$item->code_a; ?> Рисунок: <?=$item->fabric_image; ?> Штрихкод: <?=$item->barcode; ?></p>
                                                <p class="product_name">Заказчик - <?=$user->fio ?> Код цеха/Табельный номер <?=$user->login ?></p>
                                            </div>
                                            <div>
                                                <div style="flex-flow: row nowrap;"><input id="cancel_count" data-id = "<?=$item->id; ?>" type="number" value="0" min="0" max="<?=$item->qty; ?>">  ед. <label for="cancel_count"> отменить</label></div>
                                                <p>Количество: <?=$item->qty; ?> шт.</p>
                                                <p>Цена: <?=$item->price; ?> BYN</p>
                                            </div>
                                        </li>
                                    <?php endforeach;?>
                                    <li class="handle-buttons">
                                        <?php if ($order->status == 0) :?>
                                            <a  class="buttonc" id="handle-order" data-id = "<?=$order->id;?>">Обработать заказ</a>
                                        <?php endif;?>
                                    </li>
                                </ul>
                            </div>
                        <?php endforeach;?>
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