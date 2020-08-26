<?php
$this->title = 'Сообщения';

use yii\helpers\Url;

?>
<section id="main-content">
    <section class="wrapper">
        <div class="col-md-12 stats-info stats-last widget-shadow">
            <div class="stats-last-agile">
                <div class="stats-title">
                    <h4 class="title">Сообщения обратной связи</h4>
                </div>

                <div>
                    <ul class="messages_can">
                        <?php foreach ($model as $item) :?>
                        <?php if($item->status == 0) :?>
                        <li class="no-view">
                            <div><i class="fa fa-envelope"></i></div>
                            <p class="messages_can_name"><?=$item->name?></p>
                            <p class="messages_can_topic">Сообщение с сайта</p>
                            <div><a href="<?= Url::to(['foodadmin/viewmess', 'id' => $item->id])?>"><i class="fa fa-eye"></i></a></div>
                        </li>
                        <?php else: ?>
                        <li class="view-mes">
                            <div><i class="fa fa-check"></i></div>
                            <p class="messages_can_name"><?=$item->name?></p>
                            <p class="messages_can_topic">Сообщение с сайта</p>
                            <div><a href="<?= Url::to(['foodadmin/viewmess', 'id' => $item->id])?>"><i class="fa fa-eye"></i></a></div>
                        </li>
                        <?php endif; ?>
                        <?php endforeach;?>
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
