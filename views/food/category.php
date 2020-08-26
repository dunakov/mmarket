<?php
use app\models\Food_categories;

if(isset($_GET['id']))
{
    $category_name = Food_categories::findOne(['id' => $_GET['id']]);
    $this->title = $category_name->name;
}
else
{
    $this->title = 'Продукты питания';
}
use yii\widgets\LinkPager;

?>

<div class="products-breadcrumb">
    <div class="container">
        <ul>
            <li><i class="fa fa-home" aria-hidden="true"></i><a href="<?= \yii\helpers\Url::to(['site/index'])?>">Главная</a><span>|</span></li>
            <li>Продукты питания<span>|</span></li>
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
            <?= $this->render('@app/views/foodmenu');?>
        </nav>
    </div>
    <div class="shop_banner_nav_right">
        <div class="shops_shop_banner_nav_right_grid">
            <?php if(!isset($_GET['type'])) : ?>
                <h3><?= $this->title;?></h3>
            <?php else: ?>
                <h3><?=$_GET['type']?></h3>
            <?php endif; ?>
            <div class="shops_shop_banner_nav_right_grid1">
                <div class="flex-nav_right">
                    <?php foreach ($models as $item) : ?>
                            <div class="col-md-3 shops_shop_banner_left">
                                <div class="hover14 column">
                                    <div class="agile_top_brand_left_grid">
                                        <div class="agile_top_brand_left_grid1">
                                            <figure>
                                                <div class="snipcart-item block" >
                                                    <div class="snipcart-thumb">
                                                        <a href="<?= \yii\helpers\Url::to(['food/product', 'id' =>$item['id']])?>"">
                                                            <div class="tags">
                                                                <?= \yii\helpers\Html::img('@web/images/warehouse.png', ['alt'=>'some']);?>
                                                            </div>
                                                        <?php if ($item->image == '' ) :?>
                                                            <?= \yii\helpers\Html::img('@web/images/'.'noimage.jpg', ['alt'=>$item->name, 'class'=>'img-responsive']);?>
                                                        <?php else: ?>
                                                            <?= \yii\helpers\Html::img('@web'.$item->image, ['alt'=>$item->name, 'class'=>'img-responsive']);?>
                                                        <?php endif; ?>
                                                        </a>
                                                        <p><?= $item->name;?></p>
                                                        <?php if ($item->weighted == 1) :?>
                                                        <p style="min-height: auto; margin-top: 0px; text-transform: uppercase;">Фасовка: <?=$item->packing_size;?> кг.</p>
                                                        <h4><?= $item->price_per_kg.' BYN за кг.';?></h4>
                                                        <?php else: ?>
                                                            <p style="min-height: auto; margin-top: 0px; text-transform: uppercase;">Фасовка: <?=$item->packing_size;?></p>
                                                            <h4><?= $item->price_per_kg.' BYN';?></h4>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="snipcart-details top_brand_home_details">
                                                        <button class="button" data-category = "food" data-id = "<?=$item['id']?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i>В корзину</button>
                                                    </div>
                                                </div>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php endforeach; ?>
                    <div class="col-md-3 shops_shop_banner_left" style="height: 0px; border: none; padding: 0;">
                    </div>
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

