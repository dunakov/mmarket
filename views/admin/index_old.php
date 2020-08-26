<?php
$this->title = 'Admin Panel';
?>
<div class="admin-wrap">
    <div class="excel-block">
        <label for="from">От</label>
        <input type="text" id="from">
        <label for="to">До</label>
        <input type="text" id="to">
        <?= \yii\helpers\Html::img("@web/images/excel.png", ['alt' => 'excel_ico', 'id' => 'excelimg', 'height' => 50]) ?>
    </div>
    <ul class="user_orders">
        <?php foreach($models  as $order):?>
            <li data-toggle="collapse" class="collapse-button" data-target="#<?=$order->id; ?>">
                <p class = "number_order">№ <?=$order->id; ?></p>
                <div>
                    <p class = "status_order"><?=$order->status?'<span class = "text-success">Обработан</span>' : '<span class = "text-danger">Не обработан</span>'?></p>
                    <p>|</p>
                    <p class = "time_order"><?=$order->time_order;?></p>
                    <span id="#<?=$order->id; ?>" class="glyphicon glyphicon-menu-down"></span>
                </div>
            </li>
            <div id="<?=$order->id; ?>" class="collapse">
                <?php $order_items = \app\models\OrderItems::find()->where(['order_id' => $order->id])->all(); ?>
                <ul class="user_orders_info">
                    <?php $user = \app\models\Users::findOne(['id' => $order->user_id]) ?>
                    <?php foreach($order_items as $item):?>
                        <li>
                            <div>
                                <p class="product_name"><?=$item->name; ?></p>
                                <p>Код: <?=$item->code; ?> Артикул: <?=$item->code_a; ?> Модель: <?=$item->model; ?> Номер ткани: <?=$item->fabric_number; ?> Номер рисунка: <?=$item->fabric_image; ?></p>
                                <p class="product_name">Заказчик <?=$user->fio ?> Код цеха/Табельный номер <?=$user->login ?></p>
                            </div>
                            <div>
                                <p>Количество: <?=$item->qty; ?> шт.</p>
                                <p>Цена: <?=$item->price; ?> BYN</p>
                            </div>
                        </li>
                    <?php endforeach;?>
                    <li class="handle-buttons">
                        <?php if ($order->status == 0) :?>
                        <a href="" class="buttonc" id="handle-order" data-id = "<?=$order->id;?>">Обработать заказ</a>
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