<?php

$this->title = $model->name;

?>

<div class="products-breadcrumb">
    <div class="container">
        <ul>
            <li><i class="fa fa-home" aria-hidden="true"></i><a href="<?= \yii\helpers\Url::to(['site/index'])?>">Главная</a><span>|</span></li>
            <li><?=$this->title;?></li>
        </ul>
    </div>
</div>
<!-- //products-breadcrumb -->
<!-- banner -->
<div class="banner"><w></w>
    <div class="shop_banner_nav_left">
        <nav class="navbar nav_bottom">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header nav_2">
                <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <?= $this->render('@app/views/foodmenu') ?>
        </nav>
    </div>
    <div class="shop_banner_nav_right">
        <div class="agileinfo_single product-m">
            <h5><?=$model->name?></h5>
            <div class="col-md-4 agileinfo_single_left">
                <?php if ($model->image == '' ) :?>
                    <?= \yii\helpers\Html::img('@web/images/'.'noimage.jpg', ['alt'=>$model->name, 'class'=>'img-responsive product-responsive']);?>
                <?php else: ?>
                    <?= \yii\helpers\Html::img('@web'.$model->image, ['alt'=>$model->name, 'class'=>'img-responsive product-responsive']);?>
                <?php endif; ?>
                                <div class="panel panel-danger">
                    <div style="padding:1.5em; text-align: justify; line-height: 1.2em;" class="panel-body">Информация о товаре предоставлена для ознакомления и не является публичной офертой. Изображения на сайте представлены только в ознакомительных целях. Из-за особенностей отображения на мониторе реальный внешний вид продукции и, в частности, её цвет, может отличаться от представленного на фотография.</div>
                </div>
            </div>

            <div class="col-md-8 agileinfo_single_right">
                <!--<div class="w3agile_description">
                    <h4>Артикул : <?/*=$model->code_a*/?></h4>
                </div>-->

                <div class="w3agile_description">
                    <h4>Описание :</h4>
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>Размер фасовки</td>
                            <?php if ($model->weighted == 1) :?>
                                <td><?= $model->packing_size.' кг.';?></td>
                            <?php else: ?>
                                <td><?= $model->packing_size?></td>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <td>Описание</td>
                            <td><?= $model->description;?></td>
                        </tr>
                        <tr>
                            <?php if ($model->weighted == 1) :?>
                                <td><h4>Цена за кг.</h4></td>
                                <td><?= $model->price_per_kg.' BYN.';?></td>
                            <?php else: ?>
                                <td><h4>Цена за фасовку</h4></td>
                                <td><h4><?= $model->price_per_kg.' BYN';?></h4></td>
                            <?php endif; ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="snipcart-item block">
                    <div class="snipcart-details agileinfo_single_right_details">
                        <form action="#" method="post">
                            <fieldset>
                                <button class="button" data-id = "<?=$model->id?>" data-category = "food"><i class="fa fa-shopping-cart" aria-hidden="true"></i>В корзину</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<!-- //banner -->
