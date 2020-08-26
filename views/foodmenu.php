<?php
/**
 * Created by PhpStorm.
 * User: uit09
 * Date: 18.10.2019
 * Time: 15:22
 */
use app\models\Food_categories;
use yii\helpers\Url;
$model = Food_categories::find()->all();
/*debug($model);
die();*/
?>
<div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
    <ul class="nav navbar-nav nav_1">
        <?php foreach ($model as $item) :?>
        <?php if (isset($_GET['id']) && ($item->id == $_GET['id'])) :?>
        <li class="mainpoint active">
            <a href="<?= Url::to(['food/category', 'id' => $item->id])?>"><?=$item->name;?></a>
        </li>
        <?php else:?>
        <li class="mainpoint">
           <a href="<?= Url::to(['food/category', 'id' => $item->id])?>"><?=$item->name;?></a>
        </li>
        <?php endif; ?>
        <?php endforeach; ?>
</div>

