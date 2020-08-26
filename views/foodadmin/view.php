<?php
$this->title = 'Просмотр товаров';
use app\models\Food_categories;
use yii\helpers\Url;
$model_cat = Food_categories::find()->all();
?>
<section id="main-content">
    <section class="wrapper">
        <div class="col-md-12 stats-info stats-last widget-shadow">
            <div class="stats-last-agile">
                <div class="stats-title">
                    <h4 class="title">Просмотр товаров</h4>
                </div>

                <div class="form-group field-food_products-category_id view_ad_cat">
                    <label class="control-label" for="food_products-category_id">Категория</label>
                    <select id="food_products-category_id" class="form-control" name="Food_products[category_id]" onchange="top.location=this.value">
                        <option value="<?= \yii\helpers\Url::to(['foodadmin/view'])?>">Все категории</option>
                        <?php foreach ($model_cat as $cat) :?>
                        <?php if(isset($_GET['category']) && $cat->id == $_GET['category']) :?>
                                <option selected value="<?= \yii\helpers\Url::to(['foodadmin/view', 'category' => $cat->id])?>"><?=$cat->name;?></option>
                        <?php else: ?>
                                <option value="<?= \yii\helpers\Url::to(['foodadmin/view', 'category' => $cat->id])?>"><?=$cat->name;?></option>
                        <?php endif ?>
                        <?php endforeach; ?>
                    </select>

                    <div class="help-block"></div>
                </div>
                <div class="wr-user_orders">
                <ul class="user_orders">
                    <?php foreach ($model as $item) :?>
                    <?php $model_cat = Food_categories::findOne($item->category_id) ?>
                    <div class="view-con">
                        <div>
                            <p><span class="bold-con">ID:</span> <?=$item->id ?></p>
                            <p><span class="bold-con">Категория:</span> <?=$model_cat->name?> </p>
                            <p><span class="bold-con">Название:</span> <?=$item->name ?></p>
                        </div>
                        <div>
                            <?php if ($item->weighted == 1) :?>
                                <p><span class="bold-con">Цена за кг:</span> <?=$item->price_per_kg. ' .BYN' ?></p>
                            <?php else: ?>
                                <p><span class="bold-con">Цена за шт:</span> <?=$item->price_per_kg. ' .BYN' ?></p>
                            <?php endif; ?>
                            <p><span class="bold-con">Размер фасовки:</span> <?=$item->packing_size?> </p>
                            <p><span class="bold-con">Количество:</span> <?=$item->qty?> </p>
                        </div>
                        <div>
                            <a href="<?= \yii\helpers\Url::to(['foodadmin/update', 'id' => $item->id])?>"><i class="fa fa-pencil"></i></a>
                        </div>

                    </div>
                    <?php endforeach; ?>
                </ul>
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
