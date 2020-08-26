<?php
$this->title = 'Бельё постельное';
use yii\widgets\LinkPager;
use app\models\OrderItems;
use app\models\TUSER;
use app\models\Users;
$userlimit = Users::find()->where(['id' => \Yii::$app->user->getId()])->one();
$blacklist = TUSER::findOne(['FIO' => $userlimit->fio]);
?>

<div class="products-breadcrumb">
    <div class="container">
        <ul>
            <li><i class="fa fa-home" aria-hidden="true"></i><a href="<?= \yii\helpers\Url::to(['site/index'])?>">Главная</a><span>|</span></li>
            <li>Домашний текстиль<span>|</span></li>
            <li class="category-title"><?=$this->title;?></li>
        </ul>
    </div>
</div>
<!-- banner -->
<div class="banner">
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
            <?= $this->render('@app/views/leftmenu') ?>
        </nav>
    </div>
    <div class="shop_banner_nav_right">
        <div class="shops_shop_banner_nav_right_grid">
            <?php if(!isset($_GET['subcategory'])) : ?>
            <h3><?= $this->title;?></h3>
            <?php else: ?>
                <h3><?= $this->title;?> - <?=$_GET['subcategory']?></h3>
            <?php endif; ?>
            <div class="shops_shop_banner_nav_right_grid1">
                <div class="flex-nav_right">
                    <?php foreach ($models as $item) : ?>
                        <?php $param = $item['barcode'];
                        $arr = \Yii::$app->blakit->createCommand('select sum(qty) from order_items where preorder = 1 and barcode =' . $param)->queryOne();
                        ?>
                        <?php if((countWarehouse($item['barcode']) - @$arr['sum(qty)']) > 0) :?>
                            <div class="col-md-3 shops_shop_banner_left">
                                <div class="hover14 column">
                                    <div class="agile_top_brand_left_grid">
                                        <div class="agile_top_brand_left_grid1">
                                            <figure>
                                                <div class="snipcart-item block" >
                                                    <div class="snipcart-thumb">
                                                        <a href="<?= \yii\helpers\Url::to(['blakit/product', 'category' => pathinfo(__FILE__, PATHINFO_FILENAME), 'id' =>$item['id']])?>">
                                                            <div class="tags">

                                                                <?= \yii\helpers\Html::img('@web/images/warehouse.png', ['alt'=>'some']);?>
                                                            </div>
                                                            <?= \yii\helpers\Html::img('@web/images/'.$item->image, ['alt'=>$item->barcode, 'class'=>'img-responsive']);?>
                                                        </a>
                                                        <p><?= $item->name;?></p>
                                                        <p style = "min-height: auto; margin-top: 0px; text-transform: uppercase;">На складе <?=(countWarehouse($item['barcode']) - @$arr['sum(qty)']) ?> шт.</p>
                                                        <h4><?= realPrice($item['barcode']).' BYN';?></h4>
                                                    </div>
                                                    <?php if($blacklist != null && $blacklist->BLACKLIST != 1) :?>
                                                        <div class="snipcart-details top_brand_home_details">
                                                            <button class="button" data-category = "<?=pathinfo(__FILE__, PATHINFO_FILENAME)?>" data-id = "<?=$item['id']?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i>В корзину</button>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="snipcart-details top_brand_home_details">
                                                            <button disabled style="opacity: 0.5;" class="button" data-category = "<?=pathinfo(__FILE__, PATHINFO_FILENAME)?>" data-id = "<?=$item['id']?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i>В корзину</button>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <div class="col-md-3 shops_shop_banner_left" style="height: 0px; border: none; padding: 0;">
                    </div>
                    <div class="col-md-3 shops_shop_banner_left" style="height: 0px; border: none; padding: 0;">
                    </div>
                    <div class="col-md-3 shops_shop_banner_left" style="height: 0px; border: none; padding: 0;">
                    </div>
                </div>
                <div class="pagination-blakit">
                    <?php
                    echo LinkPager::widget([
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
    </div>

    <div class="clearfix"></div>
</div>

