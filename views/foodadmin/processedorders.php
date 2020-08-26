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
                <div class="excel-block">
                    <label for="from">От</label>
                    <input type="text" id="from">
                    <label for="to">До</label>
                    <input type="text" id="to">
                    <button type="button"  id="order_date_filter" class="btn btn-success">Отфильтровать</button>
                </div>

                <ul class="user_orders user_orders-proc">
                    <p style="padding: 10px 0 10px 0;">
                        Количество заказов : <?= $count; ?>
                    </p>
                    <?php foreach($model  as $order):?>
                        <?php $user = \app\models\Users::findOne(['id' => $order->user_id]) ?>
                        <li data-toggle="collapse" class="collapse-button" data-target="#<?=$order->id; ?>">
                            <?php if ($user != null) :?>
                            <p class = "number_order">№ <?=$order->id; ?> - <?=$user->fio ?> Тел: <?=($user->user_tel != null && $user->user_tel != '') ? $user->user_tel : 'Не указан'?></p>
                            <?php else: ?>
                            <p class = "number_order">№ <?=$order->id; ?> - <?='Уволен' ?> Тел: <?='Не указан'?></p>
                            <?php endif; ?>
                            <div>
                                <p class = "status_order"><span class="label label-success">Обработанный</span></p>
                                <p>|</p>
                                <p class = "time_order"><?=$order->time_order;?></p>
                                <span id="#<?=$order->id; ?>" class="glyphicon glyphicon-menu-down"></span>
                            </div>
                        </li>
                        <div id="<?=$order->id; ?>" class="collapse">
                            <?php $order_items = \app\models\Food_order_items::find()->where(['order_id' => $order->id])->all(); ?>
                            <ul class="user_orders_info">

                                <?php foreach($order_items as $item):?>
                                <?php $cur_product = \app\models\Food_products::findOne(['id' => $item->product_id])  ?>

                                    <li>
                                        <div>
                                            <p class="product_name"><?=$cur_product->name;?></p>
                                            <p>Код товара: <?=$item->product_id;?></p>
                                            <?php if ($user != null) :?>
                                                <p class="product_name">Заказчик <?=$user->fio ?> Код цеха/Табельный номер <?=$user->login ?></p>
                                            <?php else: ?>
                                                <p class="product_name">Заказчик <?='Уволен' ?> Код цеха/Табельный номер <?='-/-' ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <label>Отменено: <?=$item->cancel_count;?></label>
                                            <p>Количество: <?=$item->qty; ?> шт.</p>
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