<?php
$this->title = 'Обработанные заказы';
?>
<section id="main-content">
    <section class="wrapper">
        <div class="col-md-12 stats-info stats-last widget-shadow">
            <div class="stats-last-agile">
                <div class="stats-title">
                    <h4 class="title">Обработаные заказы</h4>
                </div>

                <ul class="user_orders user_orders-proc">
                    <?php foreach($model  as $order):?>
                        <?php $user = \app\models\Users::findOne(['id' => $order->user_id]) ?>
                        <li data-toggle="collapse" class="collapse-button" data-target="#<?=$order->id; ?>">
                            <p class = "number_order">№ <?=$order->id; ?> - <?=$user->fio ?> Тел: <?=($user->user_tel != null && $user->user_tel != '') ? $user->user_tel : 'Не указан'?></p>
                            <div>
                                <p class = "status_order"><span class="label label-success">Обработанный</span></p>
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
                                            <p class="product_name">Заказчик <?=$user->fio ?> Код цеха/Табельный номер <?=$user->login ?></p>
                                        </div>
                                        <div>
                                            <label>Отменено: <?=$item->cancel_count;?></label>
                                            <p>Количество: <?=$item->qty; ?> шт.</p>
                                            <p>Цена: <?=$item->price; ?> BYN</p>
                                        </div>
                                    </li>
                                <?php endforeach;?>
                                <li class="handle-buttons">
                                    <?php if ($order->status == 0) :?>
                                        <a  class="buttonc" id="handle-order" data-id = "<?=$order->id;?>">Обработать заказ</a>
                                    <?php else:?>
                                        <a href="" class="buttonc handle-red" id="cancel-handle" data-id = "<?=$order->id;?>">Отменить обработку</a>
                                    <?php endif;?>
                                </li>
                            </ul>
                        </div>
                    <?php endforeach;?>
                </ul>
                <div class="pagination-blakit">
                    <?php
                    echo \yii\widgets\LinkPager::widget([
                        'pagination' => $pages,
                        'hideOnSinglePage' => true,
                        'nextPageCssClass' => 'next',
                        'prevPageCssClass' => 'prev',
                        'maxButtonCount' =>5,
                        'disabledPageCssClass' => '',
                    ]);
                    ?>
                </div>

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